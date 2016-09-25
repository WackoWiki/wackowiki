<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Внимание: перед проведением технических административных мероприятий <span class="underline">настоятельно</span> рекомендуется закрыть доступ к сайту!',

	// Admin panel
	'Authorization'				=> 'Авторизация',
	'AuthorizationTip'			=> 'Пожалуйста, укажите административный пароль (убедитесь также, что cookies в вашем браузере разрешены).',
	'NoRecoceryPassword'		=> 'Административный пароль не задан!',
	'NoRecoceryPasswordTip'		=> 'Внимание: отсутствие административного пароля представляет угрозу для безопасности! Укажите пароль в файле настроек и запустите программу повторно.',

	'LogFilterTip'				=> 'Отфильтровать события по критериям',
	'LogLevel'					=> 'Уровень',
	'LogLevelNotLower'			=> 'не ниже, чем',
	'LogLevelNotHigher'			=> 'не выше, чем',
	'LogLevelEqual'				=> 'соответствует',
	'LogNoMatch'				=> 'Нет событий, удовлетворяющих критериям',
	'LogDate'					=> 'Дата',
	'LogEvent'					=> 'Событие',
	'LogUsername'				=> 'Пользователь',

	'PurgeSessions'				=> 'Прочистить все сессии',
	'PurgeSessionsConfirm'		=> 'Увереный в прочистке сессий? Это прекратит сессии всех текущих пользователей.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Сессии прочищены.',

	// log
	'LogLevel1'					=> 'Критический',
	'LogLevel2'					=> 'Наивысший',
	'LogLevel3'					=> 'Высокий',
	'LogLevel4'					=> 'Средний',
	'LogLevel5'					=> 'Низкий',
	'LogLevel6'					=> 'Минимальный',
	'LogLevel7'					=> 'Отладочный',

	// Massemail
	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',

	// User approval module
	'UserApproveInfo'			=> 'Санкционировать новых пользователей.',
	'Approve'					=> 'Допустить',
	'Deny'						=> 'Отказать',
	'Pending'					=> 'Ожидает решения',
	'Approved'					=> 'Одобрено',
	'Denied'					=> 'Отказано',

	// DB Backup module
	'BackupStructure'			=> 'Структура',
	'BackupData'				=> 'Данные',
	'BackupFolder'				=> 'Каталог',
	'BackupTable'				=> 'Таблица',
	'BackupCluster'				=> 'Кластер',
	'BackupFiles'				=> 'Файлы',
	'BackupSettings'			=> 'Укажите требуемую схему резервирования. '.
									'Корневой кластер не влияет на резервное копирование глобальных файлов и файлов кэша (при их выборе они всегда сохраняются полностью).<br /> '.
									'<br /> '.
									'<span class="underline">Внимание</span>: во избежание потери информации из базы данных WackoWiki, при указании корня кластера, таблицы из данной резервной копии не будут реструктуризированы, '.
									'аналогично, при резервировании только структуры таблицы без сохранения данных. '.
									'Для полной конвертации таблиц в формат резервной копии необходимо произвести <em>полное резервирование всей базы данных (структура и содержимое) без указания кластера</em>.',
	'BackupCompleted'			=> 'Резервное копирование и архивация завершены.<br />'.
									'Пакет резервной копии сохранен в папке с названием "(дата)ГГГГММДД_(время)ЧЧММСС" в папке files/backup.<br />'.
									'Для его получения используйте FTP (не забудьте при копировании сохранять структуру каталогов и имена файлов и директорий).<br />'.
									'Восстановить резервную копию или удалить пакет можно в разделе <a href="?mode=db_restore">Восстановление</a>.',

	// DB Restore module
	'RestoreInfo'				=> 'Вы можете восстановить любой из найденных резервных пакетов, либо удалить его с сервера.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Дополнительные опции для восстановления',
	'RestoreOptionsInfo'		=> '* Перед восстановлением резервной копии <span class="underline">кластера</span> WackoWiki, '.
									'целевые таблицы не уничтожаются (дабы предотвратить потерю информации из незарезервированных кластеров). '.
									'Таким образом, в процессе восстановления будут встречаться дублированные записи. '.
									'В обычном режиме все они будут заменены записями из резервной копии (с помощью SQL-инструкции <code>REPLACE</code>), <br />'.
									'но если этот флажок установлен, все дубликаты будут пропущены (будут сохранены текущие значения записей), <br />'.
									'а добавлены в таблицу только записи с новыми ключами (SQL-инструкцией <code>INSERT IGNORE</code>).<br />'.
									'<span class="underline">Заметьте</span>: при восстановлении полной резервной копии сайта эта опция не имеет значения.<br /> '.
									'<br /> '.
									'** Если резервная копия содержит пользовательские файлы (глобальные и постраничные, файлы кэша и пр.), то в обычном режиме при восстановлении они заменят одноименные файлы, размещенные в тех же каталогах. '.
									'Эта опция позволяет сохранить текущие копии файлов, а восстановить из резервной копии только новые (отсутствующие на сервере) файлы. ',
	'IgnoreDuplicatedKeys'		=> 'Игнорировать дубликатные ключи таблицы (не заменять)',
	'IgnoreSameFiles'			=> 'Игнорировать одноименные файлы (не перезаписывать)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Весь сайт',
	'BackupRestored'			=> 'Резервная копия восстановлена, отчет выполнения приложен ниже. Чтобы удалить данную резервную копию, нажмите здесь',
	'BackupRemoved'				=> 'Выбранная резервная копия успешно удалена.',

	// User module
	'UsersAdded'				=> 'Пользователь добавлен',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Включено',
	'UsersAddNew'				=> 'Добавить нового пользователя',
	'UsersDelete'				=> 'Are you sure you want to remove user ',
	'UsersDeleted'				=> 'The user was deleted from the database.',
	'UsersRename'				=> 'Rename the user',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserName'					=> 'Username',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Language',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	// Groups module
	'GroupsMembersFor'			=> 'Участники группы',
	'GroupsDescription'			=> 'Описание',
	'GroupsModerator'			=> 'Модератор',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Редактировать группу',
	'GroupsUpdated'				=> 'Группы обновлены',
	'GroupsAlreadyExists'		=> 'Эта группа уже cуществует.',
	'GroupsAdded'				=> 'Группа добавлена.',
	'GroupsRenamed'				=> 'Группы переименована.',
	'GroupsDeleted'				=> 'Группа удалена из базы данных и всех страниц.',
	'GroupsAdd'					=> 'Добавить новую группу',
	'GroupsRename'				=> 'Удалить группу',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Are you sure you want to remove group ',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsStoreButton'			=> 'Сохранить группы',
	'GroupsSaveButton'			=> 'Submit',
	'GroupsCancelButton'		=> 'Отменить',
	'GroupsAddButton'			=> 'Добавить',
	'GroupsEditButton'			=> 'Изменить',
	'GroupsRemoveButton'		=> 'Удалить',
	'GroupsEditInfo'			=> 'Для редактирования списка групп выберите радио-кнопку.',

	'MembersAddNew'				=> 'Добавить нового участника',
	'MembersAdded'				=> 'Участник добавлен в группу.',
	'MembersRemove'				=> 'Даете добро на удаление участника ',
	'MembersRemoved'			=> 'Участник из группы удален.',
	'MembersDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',

];

?>
