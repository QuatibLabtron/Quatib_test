

const gotop = document.querySelector(".to-top")

gotop.classList.remove("active")

window.addEventListener("scroll",()=>{

  if(window.pageYOffset>100){

    gotop.classList.add("active");

  }

  else{

    gotop.classList.remove("active");

  }

})





// $(document).ready(function(){var $btn_compare=$('.btn-compare');var get_checked_id=function(e){var array=[];var count=0;$(".action--compare-add .checkbox:checked").each(function(){count++;if(count>4){alert('Cannot add more than 4 products to Compare');return!1}

// if(count>0){$btn_compare.show()}

// if(count==0||count==null){$btn_compare.hide()}

// array.push(this.value);$btn_compare.text('COMPARE ('+count+')')});if(count==0){$btn_compare.hide()}

// var ids=array.join(",");if(ids&&count>1){$btn_compare.attr('href',base_url+'compare?products='+ids)}};$(".checkbox").on("click",get_checked_id)}); 

          

// $(document).ready(function(){var $btn_compare=$('.btn-compare');var get_checked_id=function(e){var array=[];var count=0;$(".action--compare-add2 .checkbox2:checked").each(function(){count++;if(count>4){alert('Cannot add more than 4 products to Compare');return!1}

// if(count>0){$btn_compare.show()}

// if(count==0||count==null){$btn_compare.hide()}

// array.push(this.value);$btn_compare.text('COMPARE ('+count+')')});if(count==0){$btn_compare.hide()}

// var ids=array.join(",");if(ids&&count>1){$btn_compare.attr('href',base_url+'compare?products='+ids)}};$(".checkbox2").on("click",get_checked_id)}); 





$(document).ready(function(){var base_url=''; var $btn_compare=$('.btn-compare');var get_checked_id=function(e){var array=[];var count=0;$(".action--compare-add .checkbox:checked").each(function(){count++;if(count>4){alert('Cannot add more than 4 products to Compare');return!1}

if(count>0){$btn_compare.show()}

if(count==0||count==null){$btn_compare.hide()}

array.push(this.value);$btn_compare.text('COMPARE ('+count+')')});if(count==0){$btn_compare.hide()}

var ids=array.join(",");if(ids&&count>1){$btn_compare.attr('href',base_url+'compare?products='+ids)}};$(".checkbox").on("click",get_checked_id)}); 



$(document).ready(function(){var base_url=''; var $btn_compare=$('.btn-compare');var get_checked_id=function(e){var array=[];var count=0;$(".action--compare-add2 .checkbox2:checked").each(function(){count++;if(count>4){alert('Cannot add more than 4 products to Compare');return!1}

if(count>0){$btn_compare.show()}

if(count==0||count==null){$btn_compare.hide()}

array.push(this.value);$btn_compare.text('COMPARE ('+count+')')});if(count==0){$btn_compare.hide()}

var ids=array.join(",");if(ids&&count>1){$btn_compare.attr('href',base_url+'compare?products='+ids)}};$(".checkbox2").on("click",get_checked_id)}); 





          

// let hideform = document.getElementById('hideform')

// let showform = document.getElementById('showform')   

// let click =true



// hideform.addEventListener('click',()=>{

    

//     $('#showform').fadeToggle().find('.search__input').focus();

//     if(click){

//         showform.style.display="block"

//         click = false

//     }

//     else{

//         showform.style.display="none"

//         click = true

//     }

// })

          



$('.owl-carousel').owlCarousel({

    loop: true,

    margin: 10,

    nav: true,

    dots:false,

    autoplay:true,

    autoplaySpeed:3000,

    autoplayHoverPause:true,

    responsive: {

        0: {

            items: 1

        },

        500: {

            items: 2

        },

        600: {

            items: 3

        },

        1024:{

          items: 2

        },

        1200:{

            items: 3

          }

    }

})

