<?php 
if (!defined('ABSPATH')) {
    exit;
} 
include dirname(__FILE__) . '/includes/config.inc.php';
include dirname(__FILE__) . '/includes/breadcrumbs.inc.php';
?>
<table class="hh-index-table">
	<thead>
		<tr>
			<th><?php _e('Header', 'http-headers'); ?></th>
			<th style="width: 45%"><?php _e('Value', 'http-headers'); ?></th>
			<th class="hh-status"><?php _e('Status', 'http-headers'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($headers as $index => $item)
	{
		if (@$_GET['category'] != $item[2])
		{
			continue;
		}
		
		$key = $item[1];
		
		$option = get_option($key, 0);
		$isOn = (int) $option === 1;
		$value = NULL;
		if ($isOn)
		{
			$value = get_option($key .'_value');
			switch ($key)
			{
				case 'hh_age':
					$value = (int) $value;
					break;
				case 'hh_p3p':
					if (!empty($value))
					{
						$value = sprintf('CP="%s"', join(' ', array_keys($value)));
					}
					break;
				case 'hh_x_xxs_protection':
					if ($value == '1; report=') {
						$value .= get_option('hh_x_xxs_protection_uri');
					}
					break;
				case 'hh_x_powered_by':
					if (get_option('hh_x_powered_by_option') == 'unset') {
						$value = '[Unset]';
					}
					break;
				case 'hh_x_frame_options':
					$value = strtoupper($value);
					if ($value == 'ALLOW-FROM')
					{
						$value .= ' ' . get_option('hh_x_frame_options_domain');
					}
					break;
				case 'hh_strict_transport_security':
					$tmp = array();
					$hh_strict_transport_security_max_age = get_option('hh_strict_transport_security_max_age');
					if ($hh_strict_transport_security_max_age !== false)
					{
						$tmp[] = sprintf('max-age=%u', $hh_strict_transport_security_max_age);
						if (get_option('hh_strict_transport_security_sub_domains'))
						{
							$tmp[] = 'includeSubDomains';
						}
						if (get_option('hh_strict_transport_security_preload'))
						{
							$tmp[] = 'preload';
						}
					} else {
						$tmp = array(get_option('hh_strict_transport_security_value'));
					}
					if (!empty($tmp))
					{
						$value = join('; ', $tmp);
					}
					break;
				case 'hh_public_key_pins':
					$public_key_pins_sha256_1 = get_option('hh_public_key_pins_sha256_1');
					$public_key_pins_sha256_2 = get_option('hh_public_key_pins_sha256_2');
					$public_key_pins_max_age = get_option('hh_public_key_pins_max_age');
					$public_key_pins_sub_domains = get_option('hh_public_key_pins_sub_domains');
					$public_key_pins_report_uri = get_option('hh_public_key_pins_report_uri');
					if (!empty($public_key_pins_sha256_1) && !empty($public_key_pins_sha256_2) && !empty($public_key_pins_max_age)) {
							
						$public_key_pins = array();
						$public_key_pins[] = sprintf('pin-sha256="%s"', $public_key_pins_sha256_1);
						$public_key_pins[] = sprintf('pin-sha256="%s"', $public_key_pins_sha256_2);
						$public_key_pins[] = sprintf("max-age=%u", $public_key_pins_max_age);
						if ($public_key_pins_sub_domains) {
							$public_key_pins[] = "includeSubDomains";
						}
						if (!empty($public_key_pins_report_uri)) {
							$public_key_pins[] = sprintf('report-uri="%s"', $public_key_pins_report_uri);
						}
						$value = join('; ', $public_key_pins);
						if (get_option('hh_public_key_pins_report_only')) {
							$item[0] .= '-Report-Only';
						}
					}
					break;
				case 'hh_timing_allow_origin':
					if ($value == 'origin')
					{
						$value = get_option('hh_timing_allow_origin_url');
					}
					break;
				case 'hh_access_control_allow_origin':
					if ($value == 'origin')
					{
					    $value = join('<br>', get_option('hh_access_control_allow_origin_url', array()));
					}
					break;
				case 'hh_access_control_expose_headers':
				case 'hh_access_control_allow_headers':
				case 'hh_access_control_allow_methods':
					$value = join(', ', array_keys($value));
					break;
				case 'hh_content_security_policy':
					$csp = array();
					foreach ($value as $key => $val)
					{
						if (!empty($val))
						{
							$csp[] = sprintf("%s %s", $key, $val);
						}
					}
					if (!empty($csp))
					{
						$value = join('; ', $csp);
					}
					if (get_option('hh_content_security_policy_report_only')) {
						$item[0] .= '-Report-Only';
					}
					break;
				case 'hh_content_encoding':
					$value = !$value ? null : join(', ', array_keys($value));
					
					$ext = get_option('hh_content_encoding_ext');
					if (!empty($ext)) {
						$ext = join(', ', array_keys($ext));
						$value .= (!empty($value) ? '<br>' : null) . $ext;
					}
					$value = !empty($value) ? sprintf('gzip (%s)', $value) : 'gzip';
					break;
				case 'hh_vary':
					$value = !$value ? null : join(', ', array_keys($value));
					break;
				case 'hh_www_authenticate':
					$value = get_option('hh_www_authenticate_type');
					break;
				case 'hh_cache_control':
					$tmp = array();
					foreach ($value as $k => $v) {
						if (in_array($k, array('max-age', 's-maxage'))) {
							if (strlen($v) > 0) {
								$tmp[] = sprintf("%s=%u", $k, $v);
							}
						} else {
							$tmp[] = $k;
						}
					}
					$value = join(', ', $tmp);
					break;
				case 'hh_expires':
					$tmp = array();
					$types = get_option('hh_expires_type', array());
					foreach ($types as $type => $whatever) {
						list($base, $period, $suffix) = explode('_', $value[$type]);
						if (in_array($base, array('access', 'modification'))) {
							$tmp[] = $type != 'default'
								? sprintf('%s = "%s plus %u %s"', $type, $base, $period, $suffix)
								: sprintf('default = "%s plus %u %s"', $base, $period, $suffix);
						} elseif ($base == 'invalid') {
							$tmp[] = $type != 'default'
								? sprintf('%s = A0', $type)
								: sprintf('default = A0');
						}
					}
					$value = join('<br>', $tmp);
					break;
				case 'hh_cookie_security':
					$value = is_array($value) ? join(', ', array_keys($value)) : NULL;
					break;
				case 'hh_expect_ct':
					$tmp = array();
					$tmp[] = sprintf('max-age=%u', get_option('hh_expect_ct_max_age'));
					if (get_option('hh_expect_ct_enforce') == 1) {
						$tmp[] = 'enforce';
					}
					$tmp[] = sprintf('report-uri="%s"', get_option('hh_expect_ct_report_uri'));
					$value = join(', ', $tmp); 
					break;
				case 'hh_custom_headers':
					$_names = array($item[0]);
					$_values = array('&nbsp;');
					foreach ($value['name'] as $key => $name)
					{
						if (!empty($name) && !empty($value['value'][$key]))
						{
							$_names[] = '<p class="hh-p">&nbsp;&nbsp;&nbsp;&nbsp;'.$name.'</p>';
							$_values[] = '<p class="hh-p">'.$value['value'][$key].'</p>';
						}
					}
					$item[0] = join('', $_names);
					$value = join('', $_values);
					break;
				case 'hh_report_to':
				    $tmp = array();
				    foreach ($value as $a_item)
				    {
				        $tmp[] = sprintf('{"url": "%s", "group": "%s", "max-age": %u%s}',
				            $a_item['url'], $a_item['group'], $a_item['max-age'], isset($a_item['includeSubDomains']) ? ', includeSubDomains' : NULL);
				    }
				    $value = join(', ', $tmp);
				default:
					$value = !is_array($value) ? $value : join(', ', $value);
			}
		}
		$status = $isOn ? __('On', 'http-headers') : __('Off', 'http-headers');
		?>
		<tr<?php echo $isOn ? ' class="active"' : NULL; ?>>
			<td><?php echo $item[0]; ?></td>
			<td><?php echo $value; ?></td>
			<td class="hh-status hh-status-<?php echo $isOn ? 'on' : 'off'; ?>"><span><?php echo $status; ?></span></td>
			<td><a href="<?php echo get_admin_url(); ?>options-general.php?page=http-headers&header=<?php 
				echo $index; ?>"><?php _e('Edit', 'http-headers'); ?></a></td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>