//Reference : https://helloinyong.tistory.com/297 (2021-10-07)
document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages;    

  if ("IntersectionObserver" in window) {
	  function lazyload() {
	  		lazyloadImages = document.querySelectorAll(".lazy");
		    var imageObserver = new IntersectionObserver(function(entries, observer) {
		      entries.forEach(function(entry) {
		        if (entry.isIntersecting) {
		          var image = entry.target;
		          image.src = image.dataset.src;
		          image.classList.remove("lazy");
		          imageObserver.unobserve(image);
		        }
		      });
		    });

		    lazyloadImages.forEach(function(image) {
		      imageObserver.observe(image);
		    });
	  }		  
	lazyload();


	// Mutation Observer
	function lazyObserver(el){
		// 감시 대상
		let target = document.querySelector(el);
		// 감시자의 설정
		let option = {
		    attributes: true,
		    childList: true,
		    characterData: true
		};

		if(target){
			// 감시자 인스턴스 만들기
			let observer = new MutationObserver((mutations) => {
				// 노드가 변경 됐을 때의 작업
				lazyload();
			});
			// 대상 노드에 감시자 전달
			observer.observe(target, option);
		}	
	}
	
	//list.php dynamic event binding
	lazyObserver('#item-data-list');




  } else {
	  console.log('2');
    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");
    
    function lazyload () {
      if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }    

      lazyloadThrottleTimeout = setTimeout(function() {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
              img.src = img.dataset.src;
              img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) { 
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
  }

});