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
        if (currentLikeBox.data('exists') == 'yes') {
            this.deleteLike();
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
        url: universityData.root_url+"/wp-json/university/v2/manageLike",
        data: { professorID: currentLikeBox.data('professorID')},
        method: "POST", 
        success : (response) => {
            console.log(response);
        },
        error: (response) => {
            console.log(response);
        }
       });
    }

    //Unlike
    deleteLike() {
        $.ajax({
            url: universityData.root_url + "/wp-json/university/v2/manageLike",
            method: "DELETE",
            success: (response) => {
                alert(response);
            },
            error: (response) => {
                alert(response);
            }
        });
    }
}


export default Like;