<?php /* Smarty version 2.6.12, created on 2006-10-21 22:44:32
         compiled from d:%5Cdevelopment%5Cprojekte%5Cegl%5Cbeta2%5Csource%5Cweb%5Cegl_root%5Csecure%5Cworkspaces%5Cdevzone%5Ctemplates%5Cmls%5Csearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'd:\\development\\projekte\\egl\\beta2\\source\\web\\egl_root\\secure\\workspaces\\devzone\\templates\\mls\\search.tpl', 52, false),)), $this); ?>
<h2>MLS</h2>
<form method="POST">
<input type="hidden" name="action" value="go"/>
<table cellpadding="5"  align="center" border="0" width="700">
	<tr>
		<td>Suche</td>
		<td width="500"><input type="text" name="search_key" value="<?php echo $this->_tpl_vars['_post']['search_key']; ?>
" style="width:100%;"/></td>
		<td><select name="lng">
				<option <?php if ($this->_tpl_vars['_post']['lng'] == 'de'): ?>selected<?php endif; ?> value="de">Deutsch</option>
				<option <?php if ($this->_tpl_vars['_post']['lng'] == 'eng'): ?>selected<?php endif; ?> value="eng">Englisch</option>
				<option <?php if ($this->_tpl_vars['_post']['lng'] == 'fr'): ?>selected<?php endif; ?> value="fr">Französich</option>
			</select>
		</td>
		<td><input type="submit" value="starten"/></td>
	</tr>
	<tr>
		<td></td>
		<td valign="top">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="radio" <?php if ($this->_tpl_vars['_post']['search_type'] == 'keyword' || ! isset ( $this->_tpl_vars['_post']['search_type'] )): ?>checked<?php endif; ?> name="search_type" value="keyword"/>Keyword</td>
					<td>&nbsp;&nbsp;</td>
					<td><input type="radio" <?php if ($this->_tpl_vars['_post']['search_type'] == 'id'): ?>checked<?php endif; ?> name="search_type" value="id"/>ID</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<table width="200">
			<tr><td>
			<select name="workspace" style="width:100%;">
				<option <?php if ($this->_tpl_vars['_post']['workspace'] == 'all'): ?>selected<?php endif; ?> value="all">Alle Workspaces</option>
				<?php unset($this->_sections['ws']);
$this->_sections['ws']['name'] = 'ws';
$this->_sections['ws']['loop'] = is_array($_loop=$this->_tpl_vars['WORKSPACES']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['ws']['show'] = true;
$this->_sections['ws']['max'] = $this->_sections['ws']['loop'];
$this->_sections['ws']['step'] = 1;
$this->_sections['ws']['start'] = $this->_sections['ws']['step'] > 0 ? 0 : $this->_sections['ws']['loop']-1;
if ($this->_sections['ws']['show']) {
    $this->_sections['ws']['total'] = $this->_sections['ws']['loop'];
    if ($this->_sections['ws']['total'] == 0)
        $this->_sections['ws']['show'] = false;
} else
    $this->_sections['ws']['total'] = 0;
if ($this->_sections['ws']['show']):

            for ($this->_sections['ws']['index'] = $this->_sections['ws']['start'], $this->_sections['ws']['iteration'] = 1;
                 $this->_sections['ws']['iteration'] <= $this->_sections['ws']['total'];
                 $this->_sections['ws']['index'] += $this->_sections['ws']['step'], $this->_sections['ws']['iteration']++):
$this->_sections['ws']['rownum'] = $this->_sections['ws']['iteration'];
$this->_sections['ws']['index_prev'] = $this->_sections['ws']['index'] - $this->_sections['ws']['step'];
$this->_sections['ws']['index_next'] = $this->_sections['ws']['index'] + $this->_sections['ws']['step'];
$this->_sections['ws']['first']      = ($this->_sections['ws']['iteration'] == 1);
$this->_sections['ws']['last']       = ($this->_sections['ws']['iteration'] == $this->_sections['ws']['total']);
?>
					<option <?php if ($this->_tpl_vars['_post']['workspace'] == $this->_tpl_vars['WORKSPACES'][$this->_sections['ws']['index']]): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['WORKSPACES'][$this->_sections['ws']['index']]; ?>
">WS:<?php echo $this->_tpl_vars['WORKSPACES'][$this->_sections['ws']['index']]; ?>
</option>
				<?php endfor; endif; ?>
			</select>
			</td></tr>
			<tr><td>			
			<select  name="platform" style="width:100%;">
				<option <?php if ($this->_tpl_vars['_post']['platform'] == 'all'): ?>selected<?php endif; ?> value="all">Gesamte Plattform</option>
				<option <?php if ($this->_tpl_vars['_post']['platform'] == 'base'): ?>selected<?php endif; ?> value="base">Basis</option>
				<?php unset($this->_sections['mod']);
$this->_sections['mod']['name'] = 'mod';
$this->_sections['mod']['loop'] = is_array($_loop=$this->_tpl_vars['MODULES']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mod']['show'] = true;
$this->_sections['mod']['max'] = $this->_sections['mod']['loop'];
$this->_sections['mod']['step'] = 1;
$this->_sections['mod']['start'] = $this->_sections['mod']['step'] > 0 ? 0 : $this->_sections['mod']['loop']-1;
if ($this->_sections['mod']['show']) {
    $this->_sections['mod']['total'] = $this->_sections['mod']['loop'];
    if ($this->_sections['mod']['total'] == 0)
        $this->_sections['mod']['show'] = false;
} else
    $this->_sections['mod']['total'] = 0;
if ($this->_sections['mod']['show']):

            for ($this->_sections['mod']['index'] = $this->_sections['mod']['start'], $this->_sections['mod']['iteration'] = 1;
                 $this->_sections['mod']['iteration'] <= $this->_sections['mod']['total'];
                 $this->_sections['mod']['index'] += $this->_sections['mod']['step'], $this->_sections['mod']['iteration']++):
$this->_sections['mod']['rownum'] = $this->_sections['mod']['iteration'];
$this->_sections['mod']['index_prev'] = $this->_sections['mod']['index'] - $this->_sections['mod']['step'];
$this->_sections['mod']['index_next'] = $this->_sections['mod']['index'] + $this->_sections['mod']['step'];
$this->_sections['mod']['first']      = ($this->_sections['mod']['iteration'] == 1);
$this->_sections['mod']['last']       = ($this->_sections['mod']['iteration'] == $this->_sections['mod']['total']);
?>
					<option <?php if ($this->_tpl_vars['_post']['platform'] == $this->_tpl_vars['MODULES'][$this->_sections['mod']['index']]->ID): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['MODULES'][$this->_sections['mod']['index']]->ID; ?>
"><?php echo $this->_tpl_vars['MODULES'][$this->_sections['mod']['index']]->sName; ?>
 (<?php echo $this->_tpl_vars['MODULES'][$this->_sections['mod']['index']]->ID; ?>
)</option>
				<?php endfor; endif; ?>
			</select>
			</td></tr>
			</table>
		</td>
	</tr>
</table>
</form>
<?php if (isset ( $this->_tpl_vars['RESULTS'] )): ?>
<h2>Ergebnisse (<?php echo count($this->_tpl_vars['RESULTS']); ?>
)</h2>
<table width="100%" align="center" cellpadding="5" cellspacing="1">
	<tr bgcolor="#ffe4cf">
		<td width="100"><b>C-ID</td>
		<td width="100"><b>TYPE</td>
		<td width="100"><b>BUFFER</td>
		<td width="100"><b>WS</td>
		<td width="400"><b>VALUE</td>
		<td><b>TPL-VAR</b></td>
		<td><b>FILE</b></td>
	</tr>
	<?php unset($this->_sections['r']);
$this->_sections['r']['name'] = 'r';
$this->_sections['r']['loop'] = is_array($_loop=$this->_tpl_vars['RESULTS']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['r']['show'] = true;
$this->_sections['r']['max'] = $this->_sections['r']['loop'];
$this->_sections['r']['step'] = 1;
$this->_sections['r']['start'] = $this->_sections['r']['step'] > 0 ? 0 : $this->_sections['r']['loop']-1;
if ($this->_sections['r']['show']) {
    $this->_sections['r']['total'] = $this->_sections['r']['loop'];
    if ($this->_sections['r']['total'] == 0)
        $this->_sections['r']['show'] = false;
} else
    $this->_sections['r']['total'] = 0;
if ($this->_sections['r']['show']):

            for ($this->_sections['r']['index'] = $this->_sections['r']['start'], $this->_sections['r']['iteration'] = 1;
                 $this->_sections['r']['iteration'] <= $this->_sections['r']['total'];
                 $this->_sections['r']['index'] += $this->_sections['r']['step'], $this->_sections['r']['iteration']++):
$this->_sections['r']['rownum'] = $this->_sections['r']['iteration'];
$this->_sections['r']['index_prev'] = $this->_sections['r']['index'] - $this->_sections['r']['step'];
$this->_sections['r']['index_next'] = $this->_sections['r']['index'] + $this->_sections['r']['step'];
$this->_sections['r']['first']      = ($this->_sections['r']['iteration'] == 1);
$this->_sections['r']['last']       = ($this->_sections['r']['iteration'] == $this->_sections['r']['total']);
?>
	
	<?php if ($this->_sections['r']['index'] % 2 == 0): ?>
	<tr bgcolor="#EFEFEF">
	<?php else: ?>
	<tr>
	<?php endif; ?>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['key']; ?>
</td>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['module_name']; ?>
</td>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['location']; ?>
</td>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['workspace']; ?>
</td>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['value']; ?>
</td>
		<td><font style="font-size:11px"><?php echo '{'; ?>
$LNG_<?php if ($this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['location'] == 'module'): ?>MODULE<?php endif;  if ($this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['location'] == 'basic'): ?>BASIC<?php endif; ?>.<?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['key'];  echo '}'; ?>
</font></td>
		<td><?php echo $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['file']; ?>
</td>
	</tr>
	<?php endfor; endif; ?>
</table>
<?php endif; ?>

<br/><br/><br/>