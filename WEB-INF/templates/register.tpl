{$forms.groupForm.open}
<table cellspacing="4" cellpadding="7" border="0">
  <tr>
    <td>
      <table cellspacing="1" cellpadding="2" border="0">
        <tr>
          <td align="right" nowrap>{$i18n.label.group_name} (*):</td>
          <td>{$forms.groupForm.group_name.control} <a href="https://www.anuko.com/lp/tt_37.htm" target="_blank">{$i18n.label.what_is_it}</a></td>
        </tr>
        <tr>
          <td align="right">{$i18n.label.currency}:</td>
          <td>{$forms.groupForm.currency.control}</td>
        </tr>
        <tr>
           <td align="right" nowrap>{$i18n.label.language}:</td>
           <td>{$forms.groupForm.lang.control}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="right" nowrap>{$i18n.label.manager_name} (*):</td>
          <td>{$forms.groupForm.manager_name.control}</td>
        </tr>
        <tr>
          <td align="right" nowrap>{$i18n.label.manager_login} (*):</td>
          <td>{$forms.groupForm.manager_login.control}</td>
        </tr>
        <tr>
          <td align="right" nowrap>{$i18n.label.password} (*):</td>
          <td>{$forms.groupForm.password1.control}</td>
        </tr>
        <tr>
          <td align="right" nowrap>{$i18n.label.confirm_password} (*):</td>
          <td>{$forms.groupForm.password2.control}</td>
        </tr>
        <tr>
          <td align="right" nowrap>{$i18n.label.email}{if isTrue('EMAIL_REQUIRED')} (*){/if}:</td>
          <td>{$forms.groupForm.manager_email.control}</td>
        </tr>
        <tr>
          <td></td>
          <td>{$i18n.label.required_fields}</td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
          <td colspan="2" height="50" align="center">{$forms.groupForm.btn_submit.control}</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
{$forms.groupForm.close}
