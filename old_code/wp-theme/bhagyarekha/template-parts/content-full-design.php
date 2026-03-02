<?php
/**
 * Full design layout - matches original HTML design
 * Use as reference for Elementor or assign template-full-design.php to a page
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$whatsapp = get_theme_mod( 'bhagyarekha_whatsapp', '919452884067' );
$phone_clean = preg_replace( '/\D/', '', $phone );
?>

<!-- Hero -->
<div class="hero-banner">
	<div class="hero-content">
		<h1><?php esc_html_e( 'Want to discover your love crystal?', 'bhagyarekha' ); ?></h1>
		<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn"><?php esc_html_e( 'Get Advice', 'bhagyarekha' ); ?></a>
	</div>
	<div class="hero-cta-bar">
		<span class="contact-no"><?php printf( esc_html__( 'CONTACT NO. %s', 'bhagyarekha' ), esc_html( $phone ) ); ?></span>
		<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="talk-now"><?php esc_html_e( 'अभी बात करे', 'bhagyarekha' ); ?></a>
	</div>
</div>

<!-- About Us -->
<section class="about-section">
	<div class="about-content">
		<div class="about-text">
			<p class="section-subtitle"><?php esc_html_e( 'about us', 'bhagyarekha' ); ?></p>
			<h2><?php esc_html_e( 'Jyotisacharya Rajkishor Tiwari - Gold Medalist', 'bhagyarekha' ); ?></h2>
			<p><?php esc_html_e( 'With over 10 years of rich and distinguished experience in the field of astrology, Jyotishacharya Rajkishore Tiwari, a recipient of the Gold Medal from the Honorable Governor of Uttar Pradesh, holds a respected position among the renowned, trustworthy, and experienced astrologers of Varanasi. He is currently serving as a government teacher (lecturer) in an inter college. His profound understanding, scholarly approach, and disciplined study in both education and astrology set him apart.', 'bhagyarekha' ); ?></p>
			<p><?php esc_html_e( 'His accurate and clear predictions, based on in-depth study, extensive experience, and Vedic traditions, have been instrumental in bringing positive changes, guidance, and solutions to the lives of many. This is why he is considered a center of trust and reverence among the general public.', 'bhagyarekha' ); ?></p>
			<span class="phone-large"><?php echo esc_html( $phone ); ?></span>
			<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn"><?php esc_html_e( 'Request a Call', 'bhagyarekha' ); ?></a>
		</div>
		<div>
			<div class="about-image placeholder"><i class="fas fa-medal"></i></div>
			<p class="about-caption"><?php esc_html_e( 'Governor receiving gold medal from Uttar Pradesh Government in 2018', 'bhagyarekha' ); ?></p>
		</div>
	</div>
</section>

<!-- Contact CTA -->
<div class="contact-cta">
	<p class="section-subtitle"><?php esc_html_e( "Any Help We're Always Here", 'bhagyarekha' ); ?></p>
	<span class="phone">+91-<?php echo esc_html( $phone ); ?></span>
	<p style="margin: 25px 0 15px; max-width: 800px; margin-left: auto; margin-right: auto;"><?php esc_html_e( 'We can solve all types of problems for you without a birth chart, using palmistry, omens, and horary astrology.', 'bhagyarekha' ); ?></p>
	<p class="section-subtitle"><?php esc_html_e( 'need any help?', 'bhagyarekha' ); ?></p>
	<span class="phone">+91-<?php echo esc_html( $phone ); ?></span>
</div>

<!-- Services -->
<section>
	<div class="section-title">
		<p class="section-subtitle"><?php esc_html_e( 'Come with', 'bhagyarekha' ); ?></p>
		<h2><?php esc_html_e( 'Astrologer Services', 'bhagyarekha' ); ?></h2>
	</div>
	<div class="services-grid">
		<?php
		$services = array(
			array( 'icon' => 'fa-hand-paper', 'title' => 'Palmistry', 'desc' => 'I give you the best advice for success in job, business and education and wearing gems by analyzing palm lines.' ),
			array( 'icon' => 'fa-clock', 'title' => 'Muhurt', 'desc' => 'From birth to death, all work is done according to the auspicious time, the work done in auspicious time is definitely fruitful.' ),
			array( 'icon' => 'fa-heartbeat', 'title' => 'Health', 'desc' => 'Are you suffering from diseases? I give you the right Vedic remedies and advice which can improve your health and avoid major diseases in future.' ),
			array( 'icon' => 'fa-rupee-sign', 'title' => 'Finance Problem', 'desc' => 'To address financial problems, an astrologer may analyze your birth chart to identify planetary influences.' ),
			array( 'icon' => 'fa-graduation-cap', 'title' => 'Education and Job', 'desc' => 'I select you education fields as per horoscope so that you can be successful by getting prestigious job.' ),
			array( 'icon' => 'fa-home', 'title' => 'Vastu Sastra', 'desc' => 'I advise you about Vastu construction and Vastu defects according to the ancient texts of Vastu Shastra.' ),
			array( 'icon' => 'fa-baby', 'title' => 'Santan Yog', 'desc' => 'Do you have Santan Badha Yog in your Kundli? Are you not having children? I will tell you the remedies according to astrology and palmistry.' ),
			array( 'icon' => 'fa-gem', 'title' => 'Gemstone', 'desc' => 'I recommend you to wear a good gemstone which will help in positive energy, health and success in your life.' ),
			array( 'icon' => 'fa-ring', 'title' => 'Marriage', 'desc' => 'I give you the best advice for love marriage and arranged marriage, due to which your married life can be happy.' ),
		);
		foreach ( $services as $s ) :
			?>
			<div class="service-card">
				<div class="offer-tag">offer 1</div>
				<div class="icon"><i class="fas <?php echo esc_attr( $s['icon'] ); ?>"></i></div>
				<h3><?php echo esc_html( $s['title'] ); ?></h3>
				<p><?php echo esc_html( $s['desc'] ); ?></p>
				<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn"><?php esc_html_e( 'Call Now Get Free Advice', 'bhagyarekha' ); ?></a>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- Hindi Banner -->
<div class="hindi-banner">
	<p>हमारे संस्था की ओर से काशी के वैदिक विद्वानों के द्वारा महामृत्युंजय जप, ग्रह शांति, दशमहाविद्या प्रयोग, बगलामुखी प्रयोग, कर्मकांड, यज्ञ एवं सभी प्रकार के अनुष्ठान कराया जाता है |</p>
	<p style="margin-top: 22px;"><?php esc_html_e( 'need any help?', 'bhagyarekha' ); ?> <a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" style="color: #fff; font-weight: 700; font-size: 22px;">+91-<?php echo esc_html( $phone ); ?></a></p>
</div>

<!-- Pitra Dosh -->
<section class="pitra-section">
	<div class="section-title"><h2><?php esc_html_e( 'Pitra Dosh', 'bhagyarekha' ); ?></h2></div>
	<div class="pitra-content">
		<div class="pitra-image"><i class="fas fa-hand-holding-heart"></i></div>
		<div class="pitra-text">
			<p><?php esc_html_e( 'In Vedic astrology, certain planetary combinations in a birth chart and lines on the palm indicate the presence of ancestral curses, known as Pitru Dosha or Matru Dosha. This affliction can bring sorrow, childlessness, untimely death, career difficulties, and various illnesses to the entire family. These defects can be remedied through specific rituals such as Tripindi Shraddha and Narayan Bali Shraddha, performed by Vedic scholars in Kashi (Varanasi).', 'bhagyarekha' ); ?></p>
			<span class="phone-large"><?php echo esc_html( $phone ); ?></span>
			<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn"><?php esc_html_e( 'Call Now', 'bhagyarekha' ); ?></a>
		</div>
	</div>
</section>

<!-- Our Product -->
<section>
	<div class="section-title">
		<p class="section-subtitle"><?php esc_html_e( 'latest', 'bhagyarekha' ); ?></p>
		<h2><?php esc_html_e( 'Our Product', 'bhagyarekha' ); ?></h2>
	</div>
	<div class="products-grid">
		<div class="product-card">
			<div class="product-img kundali"><i class="fas fa-scroll"></i></div>
			<div class="product-info">
				<h3><?php esc_html_e( 'Handwritten Janmkundali', 'bhagyarekha' ); ?></h3>
				<p><?php esc_html_e( 'I make you the excellent and best handwritten horoscope which contains the details of accurate predictions.', 'bhagyarekha' ); ?></p>
			</div>
		</div>
		<div class="product-card">
			<div class="product-img"><i class="fab fa-google-pay" style="font-size: 64px;"></i></div>
			<div class="product-info">
				<h3><?php printf( esc_html__( 'Googlepay no......%s', 'bhagyarekha' ), esc_html( $phone ) ); ?></h3>
				<p><?php esc_html_e( 'After giving Dakshina voluntarily, you will be provided with Astrological Consultation between 5:00 PM to 10:00 PM', 'bhagyarekha' ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- Testimonials -->
<section class="testimonials-section">
	<div class="section-title">
		<p class="section-subtitle"><?php esc_html_e( 'Some words', 'bhagyarekha' ); ?></p>
		<h2><?php esc_html_e( 'testimonial', 'bhagyarekha' ); ?></h2>
	</div>
	<div class="testimonials-grid">
		<div class="testimonial-card">
			<p>"Guruji bahat hi acche tarikese sab kuch clear bolte hai or upchar bhi dete hai jisse personally mujhe bahat hi upkar mila.. Guruji ko Mera Pranam.."</p>
			<div class="author">Bapon</div>
			<div class="role"><?php esc_html_e( 'Customer', 'bhagyarekha' ); ?></div>
		</div>
		<div class="testimonial-card">
			<p>"Guruji gives enough time to tell all our problems. I have got very good results from him. We are satisfied. So we will recommend all our friends and family."</p>
			<div class="author">Muskan Singh</div>
			<div class="role"><?php esc_html_e( 'Customer', 'bhagyarekha' ); ?></div>
		</div>
		<div class="testimonial-card">
			<p>"Jyotish ke vaastavik gyan se yukt, shanka samaadhaan m sahyogi or bahut hi saral swabhaav, dharmanishth ke sath karmkand ke vishesh jaankar."</p>
			<div class="author">Dilip Bilgaiyan</div>
			<div class="role"><?php esc_html_e( 'Customer', 'bhagyarekha' ); ?></div>
		</div>
	</div>
</section>

<!-- Awards -->
<section>
	<div class="section-title">
		<p class="section-subtitle"><?php esc_html_e( 'latest', 'bhagyarekha' ); ?></p>
		<h2><?php esc_html_e( 'Awards', 'bhagyarekha' ); ?></h2>
	</div>
	<div class="awards-grid">
		<div class="award-card">
			<div class="award-img"><i class="fas fa-award"></i></div>
			<div class="award-info"><h3><?php esc_html_e( 'International Astrology Conference Certificate', 'bhagyarekha' ); ?></h3></div>
		</div>
		<div class="award-card">
			<div class="award-img"><i class="fas fa-medal"></i></div>
			<div class="award-info"><h3><?php esc_html_e( 'Awarded with gold medal', 'bhagyarekha' ); ?></h3></div>
		</div>
		<div class="award-card">
			<div class="award-img"><i class="fas fa-university"></i></div>
			<div class="award-info"><h3><?php esc_html_e( 'International Astrology Conference Banaras Hindu University Varanasi', 'bhagyarekha' ); ?></h3></div>
		</div>
		<div class="award-card">
			<div class="award-img"><i class="fas fa-trophy"></i></div>
			<div class="award-info"><h3><?php esc_html_e( 'Receiving the certificate for securing first position in Acharya at Banaras Hindu University', 'bhagyarekha' ); ?></h3></div>
		</div>
	</div>
	<p style="text-align: center; margin-top: 35px;">
		<a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" class="btn" style="padding: 16px 45px; font-size: 18px;"><?php esc_html_e( 'GET ADVICE', 'bhagyarekha' ); ?></a>
	</p>
</section>
