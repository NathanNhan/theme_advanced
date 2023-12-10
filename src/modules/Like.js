 import $ from 'jquery';
class Like {
    constructor() {
        // alert("Welcome to my teacher!!!");
        this.event();
    }


    event() {
        $(".like-box").on("click", (e) => this.dispatchLike(e))
    }

    //method
    dispatchLike(e) {
        console.log(e.target);
        var currentLikeBox = $(e.target).closest('.like-box');
        if (currentLikeBox.attr('data-exists') == 'yes') {
            this.deleteLike(currentLikeBox);
            
        } else {
            this.createLike(currentLikeBox);
        }
    }

    //Like
    createLike(currentLikeBox) {
       $.ajax({
        beforeSend: (xhr) => {
               xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
        },
        url: universityData.root_url + "/wp-json/university/v2/manageLike",
        method: "POST", 
        data: { "professorId": currentLikeBox.data("professor") },
        success : (response) => {
            // Bước 1 : Tô đậm icon like -> user đã like thành công
            currentLikeBox.attr('data-exists','yes');
            //Bước 2: Tính số lượt like 
            var likeCount = parseInt(currentLikeBox.find(".like-count").html());
            //Bước 3: Tăng số lần like lên += 1; 
            likeCount++;
            //Bước 4: Cập nhật likeCount ra DOM 
            currentLikeBox.find(".like-count").html(likeCount);
            //Bước 5: Cập nhật ID của like mới tạo vào thuộc tính data-like
            currentLikeBox.attr("data-like", `${response}`);

        },
        error: (response) => {
            console.log(response);
        }
       });
    }

    //Unlike
    deleteLike(currentLikeBox) {
        $.ajax({
            url: universityData.root_url + "/wp-json/university/v2/manageLike",
            method: "DELETE",
            data : {"like" : currentLikeBox.attr('data-like')},
            success: (response) => {
                // Bước 1 : Tô đậm icon like -> user đã like thành công
                currentLikeBox.attr('data-exists', 'no');
                //Bước 2: Tính số lượt like 
                var likeCount = parseInt(currentLikeBox.find(".like-count").html());
                //Bước 3: Tăng số lần like lên += 1; 
                likeCount--;
                //Bước 4: Cập nhật likeCount ra DOM 
                currentLikeBox.find(".like-count").html(likeCount);
                //Bước 5: Cập nhật ID của like mới tạo vào thuộc tính data-like
                currentLikeBox.attr("data-like", "");
                //Bước 6 : In ra câu luợt like đã xóa thành công 
                console.log(response);
            },
            error: (response) => {
                alert(response);
            }
        });
    }
}


export default Like;