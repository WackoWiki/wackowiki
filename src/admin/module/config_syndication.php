<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Syndication settings								##
##########################################################

$module['config_syndication'] = [
		'order'	=> 210,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_syndication($engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('SyndicationSettingsInfo');?>
	</p>
	<br>
	<?php
	$action = $_POST['_action'] ?? null;

	// update settings
	if ($action == 'syndication')
	{
		$config['noindex']						= (int) ($_POST['noindex'] ?? 0);
		$config['opensearch']					= (int) ($_POST['opensearch'] ?? 0);

		// create OpenSearch description file
		if ($engine->db->opensearch == 0 && $config['source_handler'])
		{
			$xml = new Feed($engine);
			$xml->open_search();
		}

		$config['xml_sitemap']					= (int) ($_POST['xml_sitemap'] ?? 0);
		$config['xml_sitemap_gz']				= (int) ($_POST['xml_sitemap_gz'] ?? 0);
		$config['xml_sitemap_time']				= (int) $_POST['xml_sitemap_time'];
		$config['enable_feeds']					= (int) ($_POST['enable_feeds'] ?? 0);
		$config['xml_changes_link']				= (int) $_POST['xml_changes_link'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('SyndicationSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('SyndicationSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('syndication');
?>
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2">
				<br>
					<?php echo $engine->_t('FeedsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_feeds"><strong><?php echo $engine->_t('EnableFeeds');?></strong><br>
					<small><?php echo $engine->_t('EnableFeedsInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_feeds" name="enable_feeds" value="1"<?php echo ($engine->db->enable_feeds ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('XmlChangeLink');?></strong><br>
					<small><?php echo $engine->_t('XmlChangeLinkInfo');?></small></label>
				</td>
				<td>
					<select id="xml_changes_link" name="xml_changes_link">
					<?php
						$link_modes = $engine->_t('XmlChangeLinkMode');

						foreach ($link_modes as $mode => $link_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->xml_changes_link == $mode ? 'selected' : '') . '>' . $link_mode . ' (' . $mode . ')</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('XmlSiteMap');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="xml_sitemap"><strong><?php echo $engine->_t('XmlSitemap');?></strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('XmlSitemapInfo'), '<code>' . SITEMAP_XML . '</code>');?><br>
					<code>Sitemap: <?php echo $engine->db->base_url . Ut::join_path(XML_DIR, SITEMAP_XML) . ($engine->db->xml_sitemap_gz ? '.gz' : '');?></code></small></label>
				</td>
				<td>
					<input type="checkbox" id="xml_sitemap" name="xml_sitemap" value="1"<?php echo ($engine->db->xml_sitemap ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="xml_sitemap_gz"><strong><?php echo $engine->_t('XmlSitemapGz');?></strong><br>
					<small><?php echo $engine->_t('XmlSitemapGzInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="xml_sitemap_gz" name="xml_sitemap_gz" value="1"<?php echo ($engine->db->xml_sitemap_gz ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="xml_sitemap_time"><strong><?php echo $engine->_t('XmlSitemapTime');?></strong><br>
					<small><?php echo $engine->_t('XmlSitemapTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="xml_sitemap_time" name="xml_sitemap_time" value="<?php echo (int) $engine->db->xml_sitemap_time;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('SearchSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="noindex"><strong><?php echo $engine->_t('SearchEngineVisibility');?></strong><br>
					<small><?php echo $engine->_t('SearchEngineVisibilityInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="noindex" name="noindex" value="1"<?php echo ($engine->db->noindex ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="opensearch"><strong><?php echo $engine->_t('OpenSearch');?></strong><br>
					<small><?php echo $engine->_t('OpenSearchInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="opensearch" name="opensearch" value="1"<?php echo ($engine->db->opensearch ? ' checked' : '');?>>
				</td>
			</tr>
		</table>
		<br>
		<div class="center">
			<button type="submit" id="submit"><?php echo $engine->_t('SaveButton');?></button>
			<button type="reset" id="button"><?php echo $engine->_t('ResetButton');?></button>
		</div>
<?php
	echo $engine->form_close();
}

