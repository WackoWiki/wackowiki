<?php
$lang = [

/*
   Language Settings
*/
'Charset'	=> 'utf-8',
'LangISO'	=> 'el',
'LangName'	=> 'Greek',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',

	'search_page'		=> 'Αναζήτηση',
	'login_page'		=> 'Login',
	'account_page'		=> 'Settings',
	'registration_page'	=> 'Registration',
	'password_page'		=> 'Password',

	'changes_page'		=> 'RecentChanges',
	'comments_page'		=> 'RecentlyCommented',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'RandomPage',
	#'help_page'			=> 'Βοήθεια',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title'							=> 'Εγκατάσταση WackoWiki',
'Continue'						=> 'Συνέχεια',
'Back'							=> 'Επιστροφή',
'Recommended'					=> 'Συνιστάται',
'InvalidAction'					=> 'Invalid action',

/*
   Language Selection Page
*/
'lang'							=> 'Ρυθμίσεις Γλώσσας',
'PleaseUpgradeToR6'				=> 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall'					=> 'Καλώς ορίσατε στο WackoWiki, πρόκειται να εγκαταστήσετε το WackoWiki %1. Οι επόμενες σελίδες θα σας καθοδηγήσουν στη διαδικασία εγκατάστασης.',
'PleaseBackup'					=> 'Παρακαλώ, πάρτε αντίγραφο της βάσης, του αρχείου ρυθμίσεων και όλα τα τροποποιημένα αρχεία όπως αυτά που έχουν αλλαγές σε κώδικα και προσθήκες επιρραμάτων πριν την εκκίνηση της διαδικασίας ανάβάθμισης. Αυτό θα σας προτρέψει από έναν μεγάλο πονοκέφαλο.',
'LangDesc'						=> 'Παρακαλώ επιλέξτε μια γλώσσα για την διαδικασία εγκατάστασης. Η γλώσσα αυτή θα χρησιμοποιηθεί επίσης και ως προκαθορισμένη γλώσσα για την εγκατάσταση του WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Απαιτήσεις Συστήματος',
'PhpVersion'					=> 'Έκδοση PHP',
'PhpDetected'					=> 'Εντοπίστηκε PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Προαιρετικό)',
'ModRewriteInstalled'			=> 'Εγκατεστημένο Rewrite Extension (mod_rewrite];',
'Database'						=> 'Βάση Δεδομένων',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Δικαιώματα',
'ReadyToInstall'				=> 'Έτοιμοι για εγκατάσταση;',
'Requirements'					=> 'Ο διακομιστής πρέπει να έχει τις παρακάτω σε λίστα απαιτήσεις.',
'OK'							=> 'OK',
'Problem'						=> 'Πρόβλημα',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE is not compiled with UTF-8 support.',
'NotePermissions'				=> 'Το πρόγραμμα εγκατάστασης θα προσπαθήσεις να γράψει δεδομένα ρυθμίσεων στο αρχείο %1, το οποίο βρίσκετε στον κατάλογο του WackoWiki. Για να δουλέψει αυτό, πρέπει να βεβαιωθείτε ότι ο web server σας μπορεί να γράψει σε αυτό το αρχείο. Εάν δεν μπορεί να το κάνει αυτό, θα πρέπει να το επεξεργαστείτε με το χέρι (το πρόγραμμα εγκατάστασης θα σας πει πως).<br><br>Δείτε <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> για λεπτομέρειες.',
'ErrorPermissions'				=> 'Όπως φαίνεται το πρόγραμμα εγκατάστασης δεν μπορεί αυτόματα να θέσει τις απαιτήσεις στα δικαιώματα αρχείων για το WackoWiki να δουλέψει σωστά. Θα προταθείτε αργότερα κατά την διαδικασία εγκατάστασης να τροποποιήσετε με το χέρι τις απαιτήσεις στα δικαιώματα των αρχείων στον διακομιστή σας.',
'ErrorMinPhpVersion'			=> 'Η έκδοση της PHP πρέπει να είναι μεγαλύτερη της <strong>' . PHP_MIN_VERSION . '</strong>, ο διακομιστής σας φαίνεται να τρέχει σε προηγούμενη έκδοση. Πρέπει να αναβαθμίσετε σε μία πιο πρόσφατη PHP έκδοση για δουλέψει σωστά το WackoWiki.',
'Ready'							=> 'Συγχαρητήρια, διαπιστώνεται ότι ο διακομιστής σας μπορεί να τρέξει το WackoWiki.
Οι επόμενες σελίδες θα σας περιηγήσουν στην διαδικασία παραμετροποίησης.',

/*
   Site Config Page
*/
'config-site'					=> 'Παραμετροποίηση Site',
'SiteName'						=> 'Όνομα του Wiki',
'SiteNameDesc'					=> 'Παρακαλώ εισάγεται ένα όνομα για το Wiki site σας.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Αρχική Σελίδα',
'HomePageDesc'					=> 'Πληκτρολογήστε το όνομα που θέλετε να έχει η αρχική σελίδα σας, αυτή θα είναι η προκαθορισμένη σελίδα που θα βλέπουν οι χρήστες όταν επισκέπτονται το site σας και θα πρέπει να είναι ένα <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Πολυγλωσσική Υποστήριξη',
'MultiLangDesc'					=> 'Η πολυγλωσσική υποστήριξη σας επιτρέπει να έχετε σελίδες με διαφορετικές γλωσσικές ρυθμίσεις μέσα σε μία μόνη εγκατάσταση. Εάν αυτή η επιλογή είναι ενεργοποιημένη, τότε το πρόγραμμα εγκατάστασης θα δημιουργήσει αρχικές αντικείμενα μενού για όλες τις διαθέσιμες γλώσσες στην διανομή.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Συνιστάται να επιλέξετε μόνο το σύνολο των γλωσσών που θέλετε να χρησιμοποιήσετε, άλλες σοφές επιλέγονται όλες οι γλώσσες.',
'Admin'							=> 'Όνομα Διαχειριστή',
'AdminDesc'						=> 'Εισάγεται το όνομα του διαχειριστή, αυτό πρέπει να είναι ένα <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'Password'						=> 'Συνθηματικό Διαχειριστή',
'PasswordDesc'					=> 'Επέλεξε ένα συνθηματικό για τον διαχειριστή με τουλάχιστον %1 χαρακτήρες.',
'Password2'						=> 'Επανέλαβε το συνθηματικό:',
'Mail'							=> 'Ηλεκτρονική Διεύθυνση Διαχειριστή',
'MailDesc'						=> 'Εισήγαγε την ηλεκτρονική διεύθυνση του διαχειριστή.',
'Base'							=> 'Βασικό URL',
'BaseDesc'						=> 'Το βασικό URL των WackoWiki sites σας. Τα ονόματα των σελίδων θα εξαρτώνται από αυτό, ώστε όταν θα χρησιμοποιείτε το mod_rewrite η διεύθυνση θα τελειώνει με μία κάθετο π.χ.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Κατάσταση Επανεγγραφής',
'RewriteDesc'					=> 'Η κατάσταση επανεγγραφής θα ενεργοποιηθεί εάν χρησιμοποιείται το WackoWiki με την επανεγγραφή URL.',
'Enabled'						=> 'Ενεργοποίηση:',
'ErrorAdminEmail'				=> 'Δεν έχετε εισάγει μία έγκυρη ηλεκτρονική διεύθυνση!',
'ErrorAdminPasswordMismatch'	=> 'Τα συνθηματικά ΔΕΝ ταιριάζουν!.',
'ErrorAdminPasswordShort'		=> 'Το συνθηματικό του διαχειριστή είναι πολύ μικρό, το ελάχιστο μήκος είναι %1 χαρακτήρες!',
'ModRewriteStatusUnknown'		=> 'Το πρόγραμμα εγκατάστασης δεν μπορεί να επιβεβαιώσει ότι το mod_rewrite είναι ενεργοποιημένο, παρόλα αυτά αυτό δεν σημαίνει ότι είναι απενεργοποιημένο',

'LanguageArray'	=> [
	'bg' => 'Български',
	'da' => 'Dansk',
	'de' => 'Deutsch',
	'el' => 'Ελληνικά',
	'en' => 'English',
	'es' => 'Español',
	'et' => 'Eesti',
	'fr' => 'Français',
	'hu' => 'Magyar',
	'it' => 'Italiano',
	'ja' => '日本語',
	'ko' => '한국어',
	'nl' => 'Nederlands',
	'pl' => 'Polski',
	'pt' => 'Português',
	'ru' => 'Русский',
	'zh' => '简体中文',
	'zh-tw' => '正體中文',
],

/*
   Database Config Page
*/
'config-database'				=> 'Ρυθμίσεις Βάσης',
'DbDriver'						=> 'Οδηγός',
'DbDriverDesc'					=> 'Ο οδηγός της βάσης που θέλετε να χρησιμοποιήσετε. Θα πρέπει να είναι ένας παραδοσιακός οδηγός εάν δεν έχετε εγκατεστημένο <a href="http://gr.php.net/pdo" target="_blank">PDO</a>.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Διακομιστής',
'DbHostDesc'					=> 'Το όνομα του διακομιστή βάσεων δεδομένων που τρέχει σε αυτό. Συνήθως είναι <code>127.0.0.1</code> ή <code>localhost</code> (π.χ., το ίδιο όνομα που είναι το WackoWiki site σας).',
'DbPort'						=> 'Πόρτα (Προαιρετικό)',
'DbPortDesc'					=> 'Ο αριθμός της πόρτας του διακομιστή βάσεων δεδομένων σας αν είναι προσβάσιμος σε αυτή, αφήστε το κενό εάν χρησιμοποιείτε
τον προκαθορισμένο αριθμό πόρτας.',
'Db'							=> 'Το όνομα της Βάσης',
'DbDesc'						=> 'Η βάση δεδομένων που θα χρησιμοποιήσει το WackoWiki. Αυτή η βάση πρέπει να υπάρχει ήδη για να προχωρήσουμε!',
'DbUserDesc'					=> 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'DbUser'						=> 'Όνομα Χρήστη',
'DbPasswordDesc'				=> 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'DbPassword'					=> 'Συνθηματικό',
'PrefixDesc'					=> 'Πρόθεμα όλων των πινάκων που χρησιμοποιούνται από το WackoWiki. Αυτό σας επιτρέπει να τρέχετε πολλαπλές εγκαταστάσεις του WackoWiki χρησιμοποιώντας την ίδια βάση δεδομένων ρυθμίζοντας διαφορετικά προθέματα στους πίνακες (e.g. wacko_).',
'Prefix'						=> 'Πρόθεμα Πίνακα',
'ErrorNoDbDriverDetected'		=> 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ είτε ενεργοποιήστε μία εκ των επεκτάσεων mysql, mysqli ή pdo στο php.ini αρχείο σας.',
'ErrorNoDbDriverSelected'		=> 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ επιλέξτε έναν από την λίστα.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database. This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion'			=> 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database'				=> 'Εγκατάσταση Βάσης',
'TestingConfiguration'			=> 'Έλεγχος Ρυθμίσεων',
'TestConnectionString'			=> 'Έλεγχος ρυθμίσεων σύνδεσης με την βάση δεδομένων',
'TestDatabaseExists'			=> 'Δοκιμή εάν η βάση δεδομένων που δηλώσατε υπάρχει',
'TestDatabaseVersion'			=> 'Έλεγχος ελάχιστων απαιτήσεων έκδοσης βάσης δεδομένων',
'InstallTables'					=> 'Εγκατάσταση πινάκων',
'ErrorDbConnection'				=> 'Υπήρξε ένα πρόβλημα με τις λεπτομέρειες που δώσατε για την σύνδεση με την βάση δεδομένων, παρακαλώ επιστρέψτε και ελέγξετε ότι είναι σωστά.',
'ErrorDbExists'					=> 'Η βάση δεδομένων που έχετε ρυθμίσει δεν βρέθηκε. Θυμηθείτε, χρειάζεται να υπάρχει πριν από την εγκατάσταση/αναβάθμιση του WackoWiki!',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> 'στο',
'AlterTable'					=> 'Αλλαγή του %1 Πίνακα',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Προσθήκη Προκαθορισμένων Δεδομένων',
'InstallPagesBegin'				=> 'Προσθήκη Προκαθορισμένων Σελίδων',
'InstallPagesEnd'				=> 'Ολοκλήρωση Προσθήκης Προκαθορισμένων Σελίδων',
'InstallSystemAccount'			=> 'Προσθήκη χρήστη <code>System</code>',
'InstallDeletedAccount'			=> 'Προσθήκη χρήστη <code>Deleted</code>',
'InstallAdmin'					=> 'Προσθήκη Χρήση Διαχειριστή',
'InstallAdminSetting'			=> 'Προσθήκη Χρήση Διαχειριστή',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Προσθήκη Εικόνας Λογότυπο',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Σφάλμα κατά την εισαγωγή της %1 σελίδας',
'ErrorInsertPagePermission'		=> 'Σφάλμα ρύθμισης δικαιώματος για την %1 σελίδα',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'Η %1 σελίδα ήδη υπάρχει',
'ErrorAlterTable'				=> 'Σφάλμα αλλαγής %1 πίνακα',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Δημιουργία πίνακα: %1',
'ErrorAlreadyExists'			=> 'Ο %1 υπάρχει ήδη',
'ErrorCreatingTable'			=> 'Σφάλμα κατά την δημιουργία του πίνακα: %1, δεν υπάρχει ήδη;',
'DeletingTables'				=> 'Διαγραφή πινάκων',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Εγγραφή Αρχείου Ρυθμίσεων',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Εγγραφή Αρχείου Ρυθμίσεων',
'RemovingWritePrivilege'		=> 'Αφαίρεση Δικαιώματος Εγγραφής',
'InstallationComplete'			=> 'Installation Complete',
'ThatsAll'						=> 'Αυτό ήταν όλο! Μπορείτε τώρα <a href="%1"> να δείτε το WackoWiki site σας</a>.',
'SecurityConsiderations'		=> 'Προτάσεις Ασφάλειας',
'SecurityRisk'					=> 'Σας προτείνεται να αφαιρέσετε το δικαίωμα εγγραφής στο %1 τώρα που έχει γραφτεί. Αφήνοντάς το αρχείο εγγράψιμο μπορεί να αποτελεί ρίσκο ασφάλειας!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Θα πρέπει να διαγράψετε τον κατάλογο %1 τώρα που η διαδικασία εγκατάστασης έχει ολοκληρωθεί.',
'ErrorGivePrivileges'			=> 'Το αρχείο ρυθμίσεων %1 δεν πρέπει να είναι εγγράψιμο. Θα χρειαστεί να δώσετε στον web server σας προσωρινή πρόσβαση ώστε να γράψει είτε στον κατάλογο του WackoWiki, ή ένα κενό αρχείο με όνομα %1<br>%2<br>; μην ξεχάσετε να αφαιρέσετε το δικαίωμα εγγραφής αργότερα, π.χ. %3.<br>Αν, για κάποιο λόγο, δεν μπορείτε να το κάνετε, θα πρέπει να αντιγράψετε το παρακάτω κείμενο σε ένα νέο αρχείο και να το αποθηκεύσετε/ανεβάσετε ως %1 μέσα στον κατάλογο του WackoWiki. Όταν το κάνετε αυτόμ το WackoWiki site σας θα δουλέψει. Εάν όχι, παρακαλώ επισκεφτείται το <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'Στο επόμενο βήμα, το πρόγραμμα εγκατάστασης θα προσπαθήσει να γράψει το ανανεωμένο αρχείο ρυθμίσεων, %1.
Παρακαλώ σιγουρευτείται ότι ο web server σας έχει δικαίωμα πρόσβασης εγγραφής στο αρχείο, αλλιώς θα χρειαστεί να το επεξεργαστείται με το χέρι.
Ακόμα μία φορά, δείτε για λεπτομέρειες εδώ: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt'						=> 'εγγράψιμο στις ',
'DontChange'					=> 'μην αλλάξετε την έκδοση του wacko_version με το χέρι!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Δοκιμάστε Πάλι',

];
