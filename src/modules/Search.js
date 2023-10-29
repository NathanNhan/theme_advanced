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
        $.getJSON(universityData.root_url + "/wp-json/university/v1/universities?term=" + this.searchItem.val(), results => {
        this.resultDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${results.general_info.length ? '<ul class="link-list min-list">' : '<p>General Information no match with search</p>'}     
                 ${results.general_info.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "post" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
            ${results.general_info.length ? ' </ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${results.programmes.length ? '<ul class="link-list min-list">' : '<p>Programs no match with search</p>'}     
                 ${results.programmes.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "programmes" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
            ${results.programmes.length ? ' </ul>' : ''}

            <h2 class="search-overlay__section-title">Professors</h2>
            ${results.professors.length ? '<ul class="link-list min-list">' : '<p>Professions Information no match with search</p>'}     
                 ${results.professors.map(item => `<li class="professor-card__list-item">
                            <a class="professor-card" href=${item.permalink}>
                                <img class="professor-card__image" src=${item.image} alt="">
                              <span class="professor-card__name">${item.title}</span>
                            </a>
                          </li>`).join('')}
            ${results.professors.length ? ' </ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length ? '<ul class="link-list min-list">' : '<p>Events no match with search</p>'}     
                 ${results.events.map(item => `<div class="event-summary">
                  <a class="event-summary__date t-center" href="${item.permalink}">
                    <span class="event-summary__month">${item.month}</span>
                    <span class="event-summary__day">${item.day}</span>  
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                    <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
                  </div>
</div>`).join('')}
            ${results.events.length ? ' </ul>' : ''}
          </div>
        </div>
      `)
      this.isSpinnerVisible = false
    })
        // this.resultDiv.html('Đây là chỗ hiển thị kết quả');
        // this.spinnerVisible = false;
        // $.when(
        //     $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchItem.val()),
        //     $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchItem.val())
        // ).then((posts, pages) => {
        //     // console.log(posts);
        //     // console.log(pages);
        //     var combineResults = posts[0].concat(pages[0]);
        //     this.resultDiv.html(`
        //             <h2 class="search-overlay__section-title">General Information</h2>
        //             ${combineResults.length ? '<ul class="link-list min-list">' : '<p>General Information no match with search</p>'}     
        //                 ${combineResults.map(item => `<li><a href='${item.link}'>${item.title.rendered} ${item.type == "post" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
        //             ${combineResults.length ? ' </ul>' : ''}
        //         `)
        //     this.spinnerVisible = false;
        // }, () => {
        //     this.resultDiv.html("<p>Error Unexpeted in search!!!</p>");
        // })

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