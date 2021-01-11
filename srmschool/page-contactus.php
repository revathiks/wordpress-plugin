<?php
/**
 * 
 * Template Name: ContactUs
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
	<section class="sec-6 grid-inner-fix grid-bng-6">
				<div class="container banner-txt-2"></div>
			</section>
       <section class="sec-7">
				<div class="container">
					<div class="contact-info" id="enquire">
						<div class="col-41">
							<h3 class="text-tr">Enquire now</h3>
							<p>Drop us a message, we will contact you.</p>
								<?php echo do_shortcode('[contact-form-7 id="180" title="Contact form 1"]');  ?>
										</div>
										<div class="col-8">
										<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15560.610929387738!2d80.07316666153453!3d12.833405337740997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52f7ba32551425%3A0xd616d4e8b8ab18c9!2sSRM+Public+School!5e0!3m2!1sen!2sin!4v1494225158098" width="800" height="525" frameborder="0" style="border:0" allowfullscreen></iframe>
										</div>
									</div>
									<div class="details-info">
										<div class="row">
											<div class="colm-4 col-dd">
												<h6>School Address</h6>
												<p class="txt-b">SRM Public School</p>
												<p class="mar-top">Nellikuppam Road,</p>
												<p>Nandhivaram,</p>
												<p>Guduvanchery,</p>
												<p>Chennai - 603202</p>
												<p>India</p>
											</div>
											<div class="colm-6 col-dd">
												<h6>Phone :</h6>
												<p class="txt-lg">Please contact our Front Desk at 044 6749 7700 </p>
												&nbsp;
												<h6>e-mail :</h6>
												<p class="txt-lg"><a class="ab" href="mailto:admissions@srmschools.org">admissions@srmschools.org</a></p>
											</div>
											<!--div class="colm-6 col-dd">
												<h6>Phone :</h6>
												<p class="txt-lg">Please contact Ms. Vaishnavi or Ms. Caroline on 0442745 6600, or contact our hotline numbers on</p>
												<p class="txt-lg" style="margin-top:5px;"> (+91) - (44) - 2745 6600 to 6629(30 lines).</p>
												<br>
													<h6>e-mail :</h6>
													<p class="txt-lg">
														<a href="mailto:enquiries@srmschools.org" class="ab">enquiries@srmschools.org</a>
													</p>
												</div-->
												<!--<div class="colm-4 col-dd"><h6>Parent Support</h6><p>Phone: <a href="tel:+91442745 5515" class="ab">+91-44-2745 5515</a></p><p><a href="mailto:support@srmschools.in" class="ab">support@srmschools.in</a></p></div>-->
											</div>
										</div>
										<div class="qote">
											<p>It is the mark of an educated mind to be able to entertain a thought without accepting it.</p>- Aristotle 
										</div>
									</div>
								</section>  
<?php get_footer();
