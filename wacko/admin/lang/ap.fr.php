<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText'				=> 'Ap Test Text',
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Merci d&rsquo;indiquer le mot de passe d&rsquo;administration (assurez-vous également que les cookies soient autorisés par votre navigateur).',
	'NoRecoceryPassword'		=> 'le mot de passe d&rsquo;administration n&rsquo;est pas spécifié !',
	'NoRecoceryPasswordTip'		=> 'Note&nbsp;: l&rsquo; absence de mot de passe d&rsquo;administration constitue une menace pour la sécurité ! Saisissez votre mot de passe dans le fichier de configuration et exécutez le programme de nouveau.',

	'LogFilterTip'				=> 'Filtrer les événements par critère',
	'LogLevel'					=> 'Niveau',
	'LogLevelNotLower'			=> 'pas moins de',
	'LogLevelNotHigher'			=> 'pas plus de ',
	'LogLevelEqual'				=> 'égal',
	'LogNoMatch'				=> 'Aucun événement ne répond aux critères',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Événement',
	'LogUsername'				=> 'Nom d&rsquo;utilisateur',

	'PurgeSessions'				=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// log
	'LogLevel1'					=> 'critique',
	'LogLevel2'					=> 'le plus élevé',
	'LogLevel3'					=> 'élevé',
	'LogLevel4'					=> 'moyen',
	'LogLevel5'					=> 'bas',
	'LogLevel6'					=> 'le plus bas',
	'LogLevel7'					=> 'débogage',

	// Massemail
	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Files',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br />'.
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br />'.
									'<br />'.
									'<span class="underline">Attention</span>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br />'.
									'Backup package files stored in the "(date)YYYYMMDD_(time)HHMMSS" named sub-directory of <code>files/backup</code> directory.<br />'.
									'To download it use FTP (maintain the directory structure and file names when copying).<br />'.
									'To restore a backup copy or remove a package, go to <a href="?mode=db_restore">Restore database</a>.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options',
	'RestoreOptionsInfo'		=> '* Before restoring the <span class="underline">cluster backup</span>, '.
									'the target tables are not destroyed (to prevent loss of information from the clusters that have not been backed up). '.
									'Thus, during the recovery process duplicate records will occur. '.
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), '.
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), '.
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br />'.
									'<span class="underline">Notice</span>: When restore complete backup of the site, this option has no value.<br />'.
									'<br />'.
									'** If the backup contains the user files (global and perpage, cache files, etc.), '.
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. '.
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',

	// User module
	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'En fonction',
	'UsersAddNew'				=> 'Ajouter un utilisateur',
	'UsersDelete'				=> 'Êtes-vous sûr de vouloir supprimer un utilisateur ',
	'UsersDeleted'				=> 'L&rsquo;utilisateur a été supprimé de la base de données.',
	'UsersRename'				=> 'Renommer l&rsquo;utilisateur',
	'UsersRenameInfo'			=> '* Note&nbsp;: les modifications affecteront toutes les pages affectées à cet utilisateur.',
	'UsersUpdated'				=> 'Utilisateur effectivement actualisé.',

	// Groups module
	'GroupsMembersFor'			=> 'Membres du groupe',
	'GroupsDescription'			=> 'Description',
	'GroupsModerator'			=> 'Modérateur',
	'GroupsOpen'				=> 'Ouvert',
	'GroupsActive'				=> 'Actif',
	'GroupsTip'					=> 'Cliquer pour modifier le groupe',
	'GroupsUpdated'				=> 'Groupes modifiés',
	'GroupsAlreadyExists'		=> 'Ce groupe existe déjà.',
	'GroupsAdded'				=> 'Groupe effectivement ajouté.',
	'GroupsRenamed'				=> 'Groupe effectivement renommé.',
	'GroupsDeleted'				=> 'le groupe a été supprimé de la base de données et de toutes les pages.',
	'GroupsAdd'					=> 'Ajouter un groupe',
	'GroupsRename'				=> 'Renommer le groupe',
	'GroupsRenameInfo'			=> '* Note&nbsp;: la modification affectera toutes les pages affectées au groupe.',
	'GroupsDelete'				=> 'Êtes-vous sûr(e) de vouloir supprimer le groupe ',
	'GroupsDeleteInfo'			=> '* Note&nbsp;: la modification affectera tous les membres du groupe.',
	'GroupsStoreButton'			=> 'Sauvegarder les  groupes',
	'GroupsSaveButton'			=> 'Sauvegarder',
	'GroupsCancelButton'		=> 'Annuler',
	'GroupsAddButton'			=> 'Ajouter',
	'GroupsEditButton'			=> 'Modifier',
	'GroupsRemoveButton'		=> 'Effacer',
	'GroupsEditInfo'			=> 'Pour modifier la liste des groupes utilisez le bouton radio.',

	'MembersAddNew'				=> 'Ajouter un membre',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Êtes-vous sûr de vouloir ôter le membre ',
	'MembersRemoved'			=> 'Le membre a été ôté du groupe.',
	'MembersDeleteInfo'			=> '* Note&nbsp;: Les modifications affecteront tous les membres de ce groupe.',

);

?>