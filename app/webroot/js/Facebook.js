
  function checkLoginState() { 
    
    
        
      

     FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
   
     
            FB.logout(function (response){
                
                
            });
   
 
} 
     });
     document.location.reload();
  };
     
 ///document.cookie = 'fb_token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    


   
  

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '726387000774029',
    cookie      : true,
         // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.1
    
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  /*FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
               // var uid = response.authResponse.userID;
               // var accessToken = response.authResponse.accessToken;
               
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook, 
                // but has not authenticated your app
            } else {
                // the user isn't logged in to Facebook.
            }
        });*/
  
    
    };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/fr_FR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  
jQuery(function($){
      
     $('.Face').click(function(){
         var link = $(this).attr('href');
         FB.login(function(response){
             if(response.authResponse){
                
          
            
             window.location=link;
         }
         },{scope:'email'});
         return false;
            
  });
});
  

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  };
  