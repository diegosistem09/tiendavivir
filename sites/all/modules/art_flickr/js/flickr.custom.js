(function($){
    $(document).ready(function() {
        // Flickr, find your id from idgettr.com
        if ($(".flick-content").size() > 0) {
            var flickr = Drupal.settings.flickr;
            $('.flick-content').jflickrfeed({
                limit: flickr.flickrNum,
                qstrings: {
                    id: flickr.flickrID
                },
                itemTemplate: '<li class="flickr_badge_image">' +
                    '<a href="{{image_b}}" class="jackbox" data-group="flickr" target="_blank"><img src="{{image_s}}" alt="{{title}}" /><span class="hover"></span></a>' +
                    '</li>',
                itemCallback: function (data) {
                }
            });
        }

    })
})(jQuery);




