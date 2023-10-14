import $ from 'jquery';
class Search {
    // Lấy element mà các bạn muốn thao tác
    constructor() {
        //Lấy khung để hiển thị kết quả
        this.resultDiv = $('#search-overlay__results');
        // Lấy phần từ icon search 
        this.openSearch = $('.js-search-trigger');
        //Lấy nút đóng khung search
        this.closeSearch = $('.search-overlay__close');
        //Search overlay 
        this.overlay = $('.search-overlay');
        this.timing;
        // Lấy phần tử search input
        this.searchItem = $('#search-term');
        this.event();
        this.openOverlays = false;
        this.spinnerVisible = false;
        this.previousValue = '';
    }

    event() {
        // this = openSearch -> Lỗi ngay từ chỗ này rồi :))
        // Để fix lỗi : Phải có từ khóa bind để trỏ this về lại đối tượng ban đầu khởi tạo từ class Search
        this.openSearch.on("click", this.openOverlay.bind(this));
        this.closeSearch.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown",this.dispatchKeyPress.bind(this));
        
        this.searchItem.on("keyup", this.typingLogic.bind(this));

    }
 
    //Typing Logic
    typingLogic() {   
        if (this.previousValue != this.searchItem.val()) {
            clearTimeout(this.timing);
            if(this.searchItem.val()) {
                //do something
                if (!this.spinnerVisible) {
                    this.resultDiv.html('<div class="spinner-loader"></div>');
                    this.spinnerVisible = true;
                }
                this.timing = setTimeout(this.getResults.bind(this), 2000);

            } else {
                this.resultDiv.html('');
                this.spinnerVisible = false;
            }  
        }
        this.previousValue = this.searchItem.val();
    }

    //In kết quả khi người search từ khóa
    getResults() {
        // this.resultDiv.html('Đây là chỗ hiển thị kết quả');
        // this.spinnerVisible = false;
        $.when(
            $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchItem.val()),
            $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchItem.val())
        ).then((posts, pages) => {
            // console.log(posts);
            // console.log(pages);
            var combineResults = posts[0].concat(pages[0]);
            this.resultDiv.html(`
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${combineResults.length ? '<ul class="link-list min-list">' : '<p>General Information no match with search</p>'}     
                        ${combineResults.map(item => `<li><a href='${item.link}'>${item.title.rendered}</a></li>`).join('')}
                    ${combineResults.length ? ' </ul>' : ''}
                `)
            this.spinnerVisible = false;
        }, () => {
            this.resultDiv.html("<p>Error Unexpeted in search!!!</p>");
        })

    }
    //Xử lý mở màn che khi bấm phím s / đóng màn che khi bấm phím esc
    dispatchKeyPress(e) {
        if (e.keyCode == 83 && !this.openOverlays) {
        this.openOverlay();
       }
        if (e.keyCode == 27 && this.openOverlays) {
        this.closeOverlay();
       }
    }

    openOverlay() {
        // error
            this.overlay.addClass('search-overlay--active');
            $('body').addClass('body-no-scroll');
            this.openOverlays = true
    }
    closeOverlay() {
            this.overlay.removeClass('search-overlay--active');
            $('body').removeClass('body-no-scroll');
            this.openOverlays = false;
    }

    
}
export default Search;