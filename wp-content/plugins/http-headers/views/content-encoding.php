<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<tr>
	<th scope="row">Content-Encoding
		<p class="description"><?php _e('Compression is an important way to increase the performance of a Web site. For some documents, size reduction of up to 70% lowers the bandwidth capacity needs.', 'http-headers'); ?></p>
	</th>
	<td>
		<fieldset>
			<legend class="screen-reader-text">Content-Encoding</legend>
			<?php
			$content_encoding = get_option('hh_content_encoding', 0);
			foreach ($bools as $k => $v)
			{
				?><p><label><input type="radio" class="http-header" name="hh_content_encoding" value="<?php echo $k; ?>"<?php checked($content_encoding, $k); ?> /> <?php echo $v; ?></label></p><?php
			}
			?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-ce' ); ?>
		<?php do_settings_sections( 'http-headers-ce' ); ?>
		<table>
		<tbody><tr>
			<th colspan="2"><?php _e('By content type', 'http-headers'); ?></th>
		</tr><tr>
		<?php
		$items = array(
			'application/javascript', 
			'application/x-javascript',
			'application/json', 
			'application/ld+json',
			'application/manifest+json',
			'application/rdf+xml',
			'application/rss+xml',
			'application/schema+json',
			'application/vnd.geo+json',
			'application/x-web-app-manifest+json',
			'application/vnd.ms-fontobject', 
			'application/x-font-ttf', 
			'application/xhtml+xml',
			'application/xml',
			'font/opentype',
			'font/eot',
			'image/bmp',
			'image/svg+xml',
			'image/x-icon',
			'image/vnd.microsoft.icon',
			'text/javascript',
			'text/css',
			'text/html',
			'text/plain',
			'text/x-component',
			'text/xml',
		);
		$content_encoding_value = get_option('hh_content_encoding_value');
		if (!$content_encoding_value) {
			$content_encoding_value = array();
		}
		foreach ($items as $i => $item) {
			if ($i > 0 && $i % 2 === 0) {
				?></tr><tr><?php
			}
			?><td><label><input type="checkbox" class="http-header-value" name="hh_content_encoding_value[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $content_encoding_value) ? NULL : ' checked'; ?><?php echo $content_encoding == 1 ? NULL : ' readonly'; ?> /> <?php echo $item; ?></label></td><?php
		}
		?>
		</tr>
		
		<tr>
			<th colspan="2"><?php _e('By extension', 'http-headers'); ?></th>
		</tr>
		<tr>
		<?php
		$content_encoding_ext = get_option('hh_content_encoding_ext');
		if (!$content_encoding_ext) {
			$content_encoding_ext = array();
		}
		$items = array('php', 'html', 'js', 'css', 'json', 'xml', 'svg', 'txt', 'bmp', 'ico', 'ttf', 'otf', 'eot');
		foreach ($items as $i => $item) {
			if ($i > 0 && $i % 2 === 0) {
				?></tr><tr><?php
			}
			?><td><label><input type="checkbox" class="http-header-value" name="hh_content_encoding_ext[<?php echo $item; ?>]" value="1"<?php echo !array_key_exists($item, $content_encoding_ext) ? NULL : ' checked'; ?><?php echo $content_encoding == 1 ? NULL : ' readonly'; ?> /> *.<?php echo $item; ?></label></td><?php
		}
		?>
		</tr>
		
		</tbody></table>
	</td>
</tr>