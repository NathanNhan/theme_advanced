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
            this.createLike();
        }
    }

    //Like
    createLike() {
       $.ajax({
        url: universityData.root_url+"/wp-json/university/v2/manageLike",
        method: "POST", 
        success : (response) => {
            alert(response);
        },
        error: (response) => {
            alert(response);
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