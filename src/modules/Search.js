import $ from 'jquery';
class Search {
    // Lấy element mà các bạn muốn thao tác
    constructor() {
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
    }

    event() {
        
        
        // this = openSearch -> Lỗi ngay từ chỗ này rồi :))
        // Để fix lỗi : Phải có từ khóa bind để trỏ this về lại đối tượng ban đầu khởi tạo từ class Search
        this.openSearch.on("click", this.openOverlay.bind(this));
        this.closeSearch.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown",this.dispatchKeyPress.bind(this)); 
        this.searchItem.on("keydown", this.typingLogic.bind(this));

    }
 
    //Typing Logic
    typingLogic() {
        clearTimeout(this.timing);
        this.timing = setTimeout(() => {
           console.log("This is a test"); 
        }, 2000);
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