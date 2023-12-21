import $ from 'jquery';

class MyNotes {
    constructor() {
       this.events();
    }

    events () {
       $('.delete-note').on("click", this.deleteNote);
    }

    //Hàm tương ứng sự kiện nó bắt
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