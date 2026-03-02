<?php
/**
 * Our Service page content
 *
 * @package Bhagyarekha
 */

$phone = get_theme_mod( 'bhagyarekha_phone', '09452884067' );
$phone_clean = preg_replace( '/\D/', '', $phone );
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
?>
<section class="page-hero">
	<h1><?php esc_html_e( 'Astrologer Services', 'bhagyarekha' ); ?></h1>
	<p><?php esc_html_e( "Comprehensive Vedic astrology solutions for life's challenges", 'bhagyarekha' ); ?></p>
</section>

<div class="services-intro" style="background: var(--cream); padding: 50px 20px; text-align: center;">
	<p style="max-width: 700px; margin: 0 auto; font-size: 17px; color: var(--text-light);"><?php esc_html_e( 'We can solve all types of problems for you without a birth chart, using palmistry, omens, and horary astrology. Contact us for free advice.', 'bhagyarekha' ); ?></p>
</div>

<section>
	<div class="section-title">
		<p class="section-subtitle"><?php esc_html_e( 'Come with', 'bhagyarekha' ); ?></p>
		<h2><?php esc_html_e( 'Astrologer Services', 'bhagyarekha' ); ?></h2>
	</div>
	<div class="services-grid">
		<?php foreach ( $services as $s ) : ?>
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

<div class="hindi-banner">
	<p>हमारे संस्था की ओर से काशी के वैदिक विद्वानों के द्वारा महामृत्युंजय जप, ग्रह शांति, दशमहाविद्या प्रयोग, बगलामुखी प्रयोग, कर्मकांड, यज्ञ एवं सभी प्रकार के अनुष्ठान कराया जाता है |</p>
	<p style="margin-top: 20px;"><?php esc_html_e( 'need any help?', 'bhagyarekha' ); ?> <a href="tel:+91<?php echo esc_attr( $phone_clean ); ?>" style="color: #fff; font-weight: 700;">+91-<?php echo esc_html( $phone ); ?></a></p>
</div>
