objCourse = {
    init: ()=>{
        objCourse.resizer();
        objCourse.tap();
    },
    resizer: ()=>{
        let header       = document.querySelector("#site-header-inner").offsetHeight;
        window.onresize = function(event) {
            let windowheight = window.innerHeight;
            let windowwidth  = window.innerWidth;
            let altura_cont  = windowheight - header;
			if(windowwidth < 768){
				document.querySelector(".content-course-player").setAttribute("style","width:100%;height:"+ (0.5*windowwidth) +"px");
			}else{
				// document.querySelector(".content-course-leeson").setAttribute("style","height:"+ altura_cont +"px");
				document.querySelector(".content-course-player").setAttribute("style","height:"+ altura_cont +"px");
				// document.querySelector(".tab-content").setAttribute("style","overflow-y: scroll;width:100%;height:"+(player-extra-30)+"px");
			}
        };
        
        window.addEventListener("load",()=>{
            let windowheight = window.innerHeight;
            let windowwidth  = window.innerWidth;
            let altura_cont  = windowheight - header;
            if(windowwidth < 768){
				document.querySelector(".content-course-player").setAttribute("style","width:100%;height:"+ (0.5*windowwidth) +"px");
			}else{
				// document.querySelector(".content-course-leeson").setAttribute("style","height:"+ altura_cont +"px");
				document.querySelector(".content-course-player").setAttribute("style","height:"+ altura_cont +"px");
				// document.querySelector(".tab-content").setAttribute("style","overflow-y: scroll;width:100%;height:"+(player-extra-30)+"px");
			}
        });
    },
    tap:()=>{
        let tab1 = document.querySelector(".tab1");
        let tab2 = document.querySelector(".tab2");
        let tab3 = document.querySelector(".tab3");

        let pad1 = document.querySelector(".pad1");
        let pad2 = document.querySelector(".pad2");
        let pad3 = document.querySelector(".pad3");

        tab1.addEventListener("click",()=>{
            tab2.classList.remove("active");
            tab3.classList.remove("active");

            pad2.classList.remove("active");
            pad3.classList.remove("active");

            tab1.classList.add("active");
            pad1.classList.add("active");
        });

        tab2.addEventListener("click",()=>{
            tab1.classList.remove("active");
            tab3.classList.remove("active");

            pad1.classList.remove("active");
            pad3.classList.remove("active");

            tab2.classList.add("active");
            pad2.classList.add("active");
        });

        tab3.addEventListener("click",()=>{
            tab1.classList.remove("active");
            tab2.classList.remove("active");

            pad1.classList.remove("active");
            pad2.classList.remove("active");

            tab3.classList.add("active");
            pad3.classList.add("active");
        });  
    }
};

objCourse.init();