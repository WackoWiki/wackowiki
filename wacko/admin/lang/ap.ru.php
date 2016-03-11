<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText'				=> 'Ap Test Text',
	'MainNote'					=> '��������: ����� ����������� ����������� ���������������� ����������� <span class="underline">������������</span> ������������� ������� ������ � �����!',

	// Admin panel
	'Authorization'				=> '�����������',
	'AuthorizationTip'			=> '����������, ������� ���������������� ������ (��������� �����, ��� cookies � ����� �������� ���������).',
	'NoRecoceryPassword'		=> '���������������� ������ �� �����!',
	'NoRecoceryPasswordTip'		=> '��������: ���������� ����������������� ������ ������������ ������ ��� ������������! ������� ������ � ����� �������� � ��������� ��������� ��������.',

	'LogFilterTip'				=> 'Filter events by criteria',
	'LogLevel'					=> 'Level',
	'LogLevelNotLower'			=> 'not less than',
	'LogLevelNotHigher'			=> 'not higher than',
	'LogLevelEqual'				=> 'equal',
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> 'Username',

	'PurgeSessions'				=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// log
	'LogLevel1'					=> '�����������',
	'LogLevel2'					=> '���������',
	'LogLevel3'					=> '�������',
	'LogLevel4'					=> '�������',
	'LogLevel5'					=> '������',
	'LogLevel6'					=> '�����������',
	'LogLevel7'					=> '����������',

	// Massemail
	'SendToGroup'				=> 'Send to group',

	// DB Backup module
	'BackupStructure'			=> '���������',
	'BackupData'				=> '������',
	'BackupFolder'				=> '�������',
	'BackupTable'				=> '�������',
	'BackupCluster'				=> '�������',
	'BackupFiles'				=> '�����',
	'BackupSettings'			=> '������� ��������� ����� ��������������. '.
									'�������� ������� �� ������ �� ��������� ����������� ���������� ������ � ������ ���� (��� �� ������ ��� ������ ����������� ���������).<br /> '.
									'<br /> '.
									'<span class="underline">��������</span>: �� ��������� ������ ���������� �� ���� ������ WackoWiki, ��� �������� ����� ��������, ������� �� ������ ��������� ����� �� ����� �������������������, '.
									'����������, ��� �������������� ������ ��������� ������� ��� ���������� ������. '.
									'��� ������ ����������� ������ � ������ ��������� ����� ���������� ���������� <em>������ �������������� ���� ���� ������ (��������� � ����������) ��� �������� ��������</em>.',
	'BackupCompleted'			=> '��������� ����������� � ��������� ���������.<br />'.
									'����� ��������� ����� �������� � ����� � ��������� "(����)��������_(�����)������" � ����� files/backup.<br />'.
									'��� ��� ��������� ����������� FTP (�� �������� ��� ����������� ��������� ��������� ��������� � ����� ������ � ����������).<br />'.
									'������������ ��������� ����� ��� ������� ����� ����� � ������� <a href="?mode=db_restore">��������������</a>.',

	// DB Restore module
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '�������������� ����� ��� ��������������',
	'RestoreOptionsInfo'		=> '* ����� ��������������� ��������� ����� <span class="underline">��������</span> WackoWiki, '.
									'������� ������� �� ������������ (���� ������������� ������ ���������� �� ������������������� ���������). '.
									'����� �������, � �������� �������������� ����� ����������� ������������� ������. '.
									'� ������� ������ ��� ��� ����� �������� �������� �� ��������� ����� (� ������� SQL-���������� <code>REPLACE</code>), <br />'.
									'�� ���� ���� ������ ����������, ��� ��������� ����� ��������� (����� ��������� ������� �������� �������), <br />'.
									'� ��������� � ������� ������ ������ � ������ ������� (SQL-����������� <code>INSERT IGNORE</code>).<br />'.
									'<span class="underline">��������</span>: ��� �������������� ������ ��������� ����� ����� ��� ����� �� ����� ��������.<br /> '.
									'<br /> '.
									'** ���� ��������� ����� �������� ���������������� ����� (���������� � ������������, ����� ���� � ��.), �� � ������� ������ ��� �������������� ��� ������� ����������� �����, ����������� � ��� �� ���������. '.
									'��� ����� ��������� ��������� ������� ����� ������, � ������������ �� ��������� ����� ������ ����� (������������� �� �������) �����. ',
	'IgnoreDuplicatedKeys'		=> '������������ ����������� ����� ������� (�� ��������)',
	'IgnoreSameFiles'			=> '������������ ����������� ����� (�� ��������������)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> '���� ����',
	'BackupRestored'			=> '��������� ����� �������������, ����� ���������� �������� ����. ����� ������� ������ ��������� �����, ������� �����',
	'BackupRemoved'				=> '��������� ��������� ����� ������� �������.',

);

?>