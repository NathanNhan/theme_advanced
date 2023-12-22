import $ from 'jquery';

class MyNotes {
    constructor() {
       this.events();
    }

    events () {
      $('.delete-note').on("click", this.deleteNote);
      $('.edit-note').on("click", this.editNote.bind(this));
      $('.update-note').on("click", this.updateNote);
    }
    // Hàm sửa ghi chú 
    editNote(e) {
      var thisNote = $(e.target).parents("li");
      
      //Hàm xử lý khi click vào nút edit
      if(thisNote.attr("state") == 'editable') {
        //Hàm xử lý khi người click vào nút cancel
        this.cancelEdit(thisNote);
      } else {
        this.editAble(thisNote);

      }
      
    } 
  editAble(thisNote) {
      thisNote.find(".edit-note").html("<i class='fa fa-times' aria-hidden='true'></i> Cancel");
      thisNote.find(".note-title-field,.note-body-field").removeAttr("readonly").addClass("note-active-field");
      thisNote.find(".update-note").addClass("update-note--visible");
      thisNote.attr("state","editable");
    }

  cancelEdit(thisNote) {
      thisNote.find(".edit-note").html("<i class='fa fa-pencil' aria-hidden='true'></i> Edit");
      thisNote.find(".note-title-field,.note-body-field").attr("readonly","readonly").removeClass("note-active-field");
      thisNote.find(".update-note").removeClass("update-note--visible");
      thisNote.attr("state", "cancel");
    }
    //Hàm tương ứng sự kiện nó bắt
    //Hàm cập nhật data vào api 
  updateNote(e) {
    var thisNote = $(e.target).parents("li");
    var ghiChuCanCapNhat = {
      "title": thisNote.find(".note-title-field").val(),
      "content": thisNote.find(".note-body-field").val()
    }
    //Kiểm thử 
    // console.log("ghi chú", ghiChuCanCapNhat.title, ghiChuCanCapNhat.content);
    //Các bạn tạo AJAX để cập nhật nội dung ghi chú mới
  }
    deleteNote(e) {
    var noteID = $(e.target).parents("li");
      console.log(noteID.attr("data-id"));
      $.ajax({
        beforeSend: (xhr) => {
              xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
        },
        url: "http://university.test/wp-json/wp/v2/note/"+noteID.attr("data-id"),
        method : 'DELETE' ,
        success : () => {
          noteID.slideUp();
        } ,
        error: (error) => {console.log(error)} ,
      })
    }
}

export default MyNotes;