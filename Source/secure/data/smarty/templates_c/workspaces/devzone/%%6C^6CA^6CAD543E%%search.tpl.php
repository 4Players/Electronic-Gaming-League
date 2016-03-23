<?php /* Smarty version 2.6.12, created on 2008-07-22 13:23:33
         compiled from D:%5CInetpub%5CWww_root%5CEGL%5Cdemos%5Cbeta2%5Csecure%5Cworkspaces%5Cdevzone%5Ctemplates%5Cmls%5Csearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'D:\\Inetpub\\Www_root\\EGL\\demos\\beta2\\secure\\workspaces\\devzone\\templates\\mls\\search.tpl', 57, false),array('function', 'cutstr', 'D:\\Inetpub\\Www_root\\EGL\\demos\\beta2\\secure\\workspaces\\devzone\\templates\\mls\\search.tpl', 79, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['LNG_BASIC']['c1111']; ?>
</h2>
<form method="POST">
<input type="hidden" name="action" value="go"/>
<table cellpadding="5"  align="center" border="0" width="700">
	<tr>
		<td><?php echo $this->_tpl_vars['LNG_BASIC']['c1000']; ?>
</td>
		<td width="500"><input type="text" name="search_key" value="<?php echo $this->_tpl_vars['_post']['search_key']; ?>
" style="width:100%;"/></td>
		<td><select name="lng">
				<?php unset($this->_sections['lng']);
$this->_sections['lng']['name'] = 'lng';
$this->_sections['lng']['loop'] = is_array($_loop=$this->_tpl_vars['languages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['lng']['show'] = true;
$this->_sections['lng']['max'] = $this->_sections['lng']['loop'];
$this->_sections['lng']['step'] = 1;
$this->_sections['lng']['start'] = $this->_sections['lng']['step'] > 0 ? 0 : $this->_sections['lng']['loop']-1;
if ($this->_sections['lng']['show']) {
    $this->_sections['lng']['total'] = $this->_sections['lng']['loop'];
    if ($this->_sections['lng']['total'] == 0)
        $this->_sections['lng']['show'] = false;
} else
    $this->_sections['lng']['total'] = 0;
if ($this->_sections['lng']['show']):

            for ($this->_sections['lng']['index'] = $this->_sections['lng']['start'], $this->_sections['lng']['iteration'] = 1;
                 $this->_sections['lng']['iteration'] <= $this->_sections['lng']['total'];
                 $this->_sections['lng']['index'] += $this->_sections['lng']['step'], $this->_sections['lng']['iteration']++):
$this->_sections['lng']['rownum'] = $this->_sections['lng']['iteration'];
$this->_sections['lng']['index_prev'] = $this->_sections['lng']['index'] - $this->_sections['lng']['step'];
$this->_sections['lng']['index_next'] = $this->_sections['lng']['index'] + $this->_sections['lng']['step'];
$this->_sections['lng']['first']      = ($this->_sections['lng']['iteration'] == 1);
$this->_sections['lng']['last']       = ($this->_sections['lng']['iteration'] == $this->_sections['lng']['total']);
?>
				<?php if (isset ( $this->_tpl_vars['_post']['lng'] )): ?>
					<option <?php if ($this->_tpl_vars['_post']['lng'] == $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['token']): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['token']; ?>
"><?php echo $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['name']; ?>
</option>
				<?php else: ?>
					<option <?php if ($this->_tpl_vars['LANGUAGE'] == $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['token']): ?>selected<?php endif; ?> value="<?php echo $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['token']; ?>
"><?php echo $this->_tpl_vars['languages'][$this->_sections['lng']['index']]['name']; ?>
</option>
				<?php endif; ?>
				<?php endfor; endif; ?>
					
			</select>
		</td>
		<td><input type="submit" value="<?php echo $this->_tpl_vars['LNG_BASIC']['c1003']; ?>
"/></td>
	</tr>
	<tr>
		<td></td>
		<td valign="top">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="radio" <?php if ($this->_tpl_vars['_post']['search_type'] == 'keyword' || ! isset ( $this->_tpl_vars['_post']['search_type'] )): ?>checked<?php endif; ?> name="search_type" value="keyword"/><?php echo $this->_tpl_vars['LNG_BASIC']['c1001']; ?>
</td>
					<td>&nbsp;&nbsp;</td>
					<td><input type="radio" <?php if ($this->_tpl_vars['_post']['search_type'] == 'id'): ?>checked<?php endif; ?> name="search_type" value="id"/><?php echo $this->_tpl_vars['LNG_BASIC']['c1002']; ?>
</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<table width="200">
			<tr><td>
			<select name="workspace" style="width:100%;">
				<option <?php if ($this->_tpl_vars['_post']['workspace'] == 'all'): ?>selected<?php endif; ?> value="all"><?php echo $this->_tpl_vars['LNG_BASIC']['c1100']; ?>
</option>
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
				<option <?php if ($this->_tpl_vars['_post']['platform'] == 'all'): ?>selected<?php endif; ?> value="all"><?php echo $this->_tpl_vars['LNG_BASIC']['c1101']; ?>
</option>
				<option <?php if ($this->_tpl_vars['_post']['platform'] == 'base'): ?>selected<?php endif; ?> value="base"><?php echo $this->_tpl_vars['LNG_BASIC']['c1102']; ?>
</option>
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
<h2><?php echo $this->_tpl_vars['LNG_BASIC']['c1103']; ?>
 (<?php echo count($this->_tpl_vars['RESULTS']); ?>
)</h2>
<table width="100%" align="center" cellpadding="5" cellspacing="1">
	<tr bgcolor="#ffe4cf">
		<td width="100"><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1002']; ?>
</b></td>
		<td width="100"><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1107']; ?>
</b></td>
		<td width="100"><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1106']; ?>
</b></td>
		<td width="100"><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1110']; ?>
</b></td>
		<td width="400"><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1105']; ?>
</b></td>
		<td><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1109']; ?>
</b></td>
		<td><b><?php echo $this->_tpl_vars['LNG_BASIC']['c1104']; ?>
</b></td>
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
		<td><?php echo print_cut_str(array('text' => $this->_tpl_vars['RESULTS'][$this->_sections['r']['index']]['value'],'num' => 50), $this);?>
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