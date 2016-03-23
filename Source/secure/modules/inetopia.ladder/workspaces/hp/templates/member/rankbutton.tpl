<h2>{$LNG_MODULE.c9085}</h2>

<table width="100%">
{section name=ladder loop=$LADDERS}
<tr><td align="center"><img src="{$URL_ROOT}services.php?page={$CURRENT_MODULE_ID}:rankbutton&participant_id={$MEMBER_ID}&ladder_id={$LADDERS[ladder]->ladder_id}" /></td></tr>
<tr><td align="center"><textarea style="width:500;" class="egl_textbox"><img src="{$URL_ROOT}services.php?page={$CURRENT_MODULE_ID}:rankbutton&participant_id={$MEMBER_ID}&ladder_id={$LADDERS[ladder]->ladder_id}"/></textarea></td></tr>
{/section}
</table>