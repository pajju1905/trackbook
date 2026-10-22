function noop(){}

// alert helper for success/error msgs and ?msg=
document.addEventListener('DOMContentLoaded',function(){
 try{
   var el=document.querySelector('.error,.success,.warning');
   if(el&&el.innerText.trim()){alert(el.innerText.trim());el.classList.add('flash-hidden');}
   var params=new URLSearchParams(window.location.search);
   if(params.has('msg')){var m=params.get('msg');if(m)alert(decodeURIComponent(m));
     params.delete('msg');window.history.replaceState({},document.title,window.location.pathname);
   }
 }catch(e){console.log(e);}
});
