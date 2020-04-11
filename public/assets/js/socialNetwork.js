var socialNetwork = {
    init: function() {
        console.log('network');
        var twitters = document.querySelectorAll('.share_twitter');
        
        twitters.forEach(twitter => {
            twitter.addEventListener('click', function(e){
                e.preventDefault();
                var siteName = this.getAttribute('data-sitename');
                var url = this.getAttribute('data-url');
                var title = document.title;
                var shareUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) +
                    "&via=" + encodeURIComponent(siteName) +
                    "&url=" + encodeURIComponent(url);
                window.open(shareUrl, '_blank');
            });

          });
        
        var facebooks = document.querySelectorAll('.share_facebook');
        
        facebooks.forEach(facebook => {
            facebook.addEventListener('click', function(e){
                e.preventDefault();
                var url = this.getAttribute('data-url');
                var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);
                window.open(shareUrl, '_blank');
            });
        });

        var linkedins = document.querySelectorAll('.share_linkedin');

        linkedins.forEach(linkedin => {
            linkedin.addEventListener('click', function(e){
                e.preventDefault();
                var url = this.getAttribute('data-url');
                var shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent(url);
                window.open(shareUrl, '_blank');
            });
        });
    }

};

document.addEventListener('DOMContentLoaded', socialNetwork.init);