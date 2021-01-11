<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<div class="container gotop"> <a class="pull-right" id="gototop"> <img src="<?php echo get_home_url();?>/wp-content/themes/srmschool/assets/images/top.jpg" width="41" height="40" alt="Go to top" /> Go to top </a> </div>
<footer>
   <div class="col-ft">
      <div class="container">
         <div class="row"> 
             <!-- Wordpress Code by Mohideen -->          
             <?php   
            if ( has_nav_menu( 'main' ) ) : ?>                    
                            <?php
                                    wp_nav_menu( array(
                                            'theme_location' => 'main',
                                            'menu_id' => 'footer-sitemap',
                                            'container'     => 'div',
                                            'container_class' => 'row-footer',
                                    ) );
                            ?>                    
            <?php endif;
            get_template_part( 'template-parts/footer/footer', 'widgets' );
            ?>
           
         </div>
      </div>
   </div>
   <div class="info">
       <?php get_template_part( 'template-parts/footer/site', 'info' ); ?>      
   </div>
</footer>
<!--Popup /////////////////////////////// --><input class="modal-state" id="modal-1" type="checkbox" />
<div class="modal">
   <label class="modal__bg" for="modal-1"></label> 
   <div class="modal__inner">
      <label class="modal__close" for="modal-1">Close</label> 
      <div class="modal_body">
         <p class="model_header">Login</p>
         <form class="form" name="form1" method="post" action="#" onsubmit="return validate(this)">
            <br /> <label class="input2-txt">Login as</label> 
            <select class="input2">
               <option value="">Select</option>
               <option value="">Admin</option>
               <option value="">Faculty</option>
               <option value="">Parent</option>
               <option value="">Student</option>
            </select>
            <span id="name2" class="msg"></span> <label class="input2-txt">Username</label> <input type="tel" name="txtMobile" class="input2" > <span class="msg"></span> <label class="input2-txt">Password</label> <input type="text" name="txtEmail" class="input2"> <span id="mobile2" class="msg"></span> <input type="submit" name="sub" value="Submit" id="sub2"> 
         </form>
      </div>
   </div>
</div>
<!-- Live Helper Chat @ Start -->
<script type="text/javascript">
   var LHCChatOptions = {};
   LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500,domain:'srmschools.org'};
   (function() {
   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
   var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
   po.src = '//srmschools.org/lhc_support/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(check_operator_messages)/true/(top)/350/(units)/pixels/(leaveamessage)/true?r='+referrer+'&l='+location;
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
   })();
</script>
<!-- Live Support Chat @ End -->
	<script>
		jQuery(document).ready(function($){
			$("#gototop").click(function(e){
				$("html,body").animate({scrollTop:$("body").offset().top-0},"slow")
			});
		});
	</script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '175216369655726'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>

<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=175216369655726&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
<?php wp_footer(); ?>
</body></html>
