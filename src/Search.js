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
        this.event();
    }

    event() {
        // this = openSearch -> Lỗi ngay từ chỗ này rồi :))
        // Để fix lỗi : Phải có từ khóa bind để trỏ this về lại đối tượng ban đầu khởi tạo từ class Search
        this.openSearch.on("click", this.openOverlay.bind(this));
        this.closeSearch.on("click", this.closeOverlay.bind(this));
    }

    openOverlay() {
        // error
        this.overlay.addClass('search-overlay--active');
    }
    closeOverlay() {
        this.overlay.removeClass('search-overlay');
    }
}
export default Search;