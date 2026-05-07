<?php
/**
 * Theme footer.
 *
 * @package NewsVoice
 */
?>
<footer class="site-footer">
	<div class="container">
		<div class="footer-content">
			<div class="footer-col footer-about">
				<h4>Public Service på riktigt</h4>
				<p>Du läser en av Sveriges mest modiga tidningar.<br>Stöd vårt dagliga arbete med en <a href="<?php echo esc_url( home_url( '/donera/' ) ); ?>">donation</a>.</p>
			</div>
			<div class="footer-col">
				<h4>Annonsera</h4>
				<p>Vill du nå hundratusentals samhällsintresserade svenskar?<br>Kontakta vår annonssäljare <a href="mailto:anna@sasser.net">anna@sasser.net</a><br>Läs mer om <a href="<?php echo esc_url( home_url( '/annonsera/' ) ); ?>">annonsering</a>.</p>
			</div>
			<div class="footer-col">
				<h4>Kontakt</h4>
				<p>Kontakta redaktionen, tipsa oss eller bli skribent.<br><a href="mailto:redaktionen@newsvoice.se">redaktionen@newsvoice.se</a></p>
			</div>
			<div class="footer-col">
				<h4>Utgivare</h4>
				<p>Ansvarig utgivare:<br>Torbjörn Sassersson.<br>NewsVoice grundades 2011.<br>Innehållet på denna sida är skyddat enligt lagen om upphovsrätt.</p>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

