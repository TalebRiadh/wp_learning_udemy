import $ from 'jquery'
class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.events();
    }

    // 2. events
    events(){
        this.openButton.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this));
    }

    openOverlay(){
        this.searchOverlay.addClass('search-overlay--active')
        $('body').addClass('body-no-scroll')
    }
    closeOverlay(){
        this.searchOverlay.removeClass('search-overlay--active')
    }
}
export default Search