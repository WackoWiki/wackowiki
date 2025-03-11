<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'el',
'LangLocale'	=> 'el_GR',
'LangName'		=> 'Greek',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Κατηγορία',
	'groups_page'		=> 'Ομάδες',
	'users_page'		=> 'Χρήστες',

	'search_page'		=> 'Αναζήτηση',
	'login_page'		=> 'Σύνδεση',
	'account_page'		=> 'Ρυθμίσεις',
	'registration_page'	=> 'Εγγραφή',
	'password_page'		=> 'Συνθηματικό',

	'changes_page'		=> 'ΠρόσφατεςΑλλαγές',
	'comments_page'		=> 'ΠρόσφαταΣχολιασμένες',
	'index_page'		=> 'ΕυρετήριοΣελίδων',

	'random_page'		=> 'ΤυχαίαΣελίδα',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Εγκατάσταση WackoWiki',
'TitleUpdate'					=> 'Ενημέρωση WackoWiki',
'Continue'						=> 'Συνέχεια',
'Back'							=> 'Επιστροφή',
'Recommended'					=> 'Συνιστάται',
'InvalidAction'					=> 'Μη έγκυρη ενέργεια',

/*
   Language Selection Page
*/
'lang'							=> 'Ρυθμίσεις Γλώσσας',
'PleaseUpgradeToR6'				=> 'Εκτελείτε μια παλιά (προ %2) έκδοση του WackoWiki (%1). Για να ενημερώσετε σε αυτή τη νέα έκδοση του WackoWiki, πρέπει πρώτα να ενημερώσετε την εγκατάστασή σας σε %2.',
'UpgradeFromWacko'				=> 'Καλώς ήρθατε στο WackoWiki, φαίνεται ότι κάνετε αναβάθμιση από το WackoWiki %1 σε %2.  Οι επόμενες σελίδες θα σας καθοδηγήσουν στη διαδικασία αναβάθμισης.',
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
'PhpExtensions'					=> 'Επεκτάσεις PHP',
'Permissions'					=> 'Δικαιώματα',
'ReadyToInstall'				=> 'Έτοιμοι για εγκατάσταση;',
'Requirements'					=> 'Ο διακομιστής πρέπει να έχει τις παρακάτω σε λίστα απαιτήσεις.',
'OK'							=> 'ΟΚ',
'Problem'						=> 'Πρόβλημα',
'Example'						=> 'Παράδειγμα',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Στην εγκατάσταση PHP φαίνεται ότι λείπουν οι σημειωμένες επεκτάσεις PHP που απαιτούνται από το WackoWiki. ',
'PcreWithoutUtf8'				=> 'Το PCRE module της PHP  φαίνεται να έχει μεταγλωττιστεί χωρίς υποστήριξη  PCRE_UTF8.',
'NotePermissions'				=> 'Το πρόγραμμα εγκατάστασης θα προσπαθήσεις να γράψει δεδομένα ρυθμίσεων στο αρχείο %1, το οποίο βρίσκετε στον κατάλογο του WackoWiki. Για να δουλέψει αυτό, πρέπει να βεβαιωθείτε ότι ο web server σας μπορεί να γράψει σε αυτό το αρχείο. Εάν δεν μπορεί να το κάνει αυτό, θα πρέπει να το επεξεργαστείτε με το χέρι (το πρόγραμμα εγκατάστασης θα σας πει πως).<br><br>Δείτε <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> για λεπτομέρειες.',
'ErrorPermissions'				=> 'Όπως φαίνεται το πρόγραμμα εγκατάστασης δεν μπορεί αυτόματα να θέσει τις απαιτήσεις στα δικαιώματα αρχείων για το WackoWiki να δουλέψει σωστά. Θα προταθείτε αργότερα κατά την διαδικασία εγκατάστασης να τροποποιήσετε με το χέρι τις απαιτήσεις στα δικαιώματα των αρχείων στον διακομιστή σας.',
'ErrorMinPhpVersion'			=> 'Η έκδοση PHP πρέπει να είναι μεγαλύτερη από %1. Ο διακομιστής σας φαίνεται να τρέχει μια προηγούμενη έκδοση. Πρέπει να αναβαθμίσετε σε μια πιο πρόσφατη έκδοση PHP για να λειτουργήσει σωστά το WackoWiki.',
'Ready'							=> 'Συγχαρητήρια, διαπιστώνεται ότι ο διακομιστής σας μπορεί να τρέξει το WackoWiki. Οι επόμενες σελίδες θα σας περιηγήσουν στην διαδικασία παραμετροποίησης.',

/*
   Site Config Page
*/
'config-site'					=> 'Παραμετροποίηση Site',
'SiteName'						=> 'Όνομα του Wiki',
'SiteNameDesc'					=> 'Παρακαλώ εισάγεται ένα όνομα για το Wiki site σας.',
'SiteNameDefault'				=> 'ΤοWikiμου',
'HomePage'						=> 'Αρχική Σελίδα',
'HomePageDesc'					=> 'Πληκτρολογήστε το όνομα που θέλετε να έχει η αρχική σελίδα σας, αυτή θα είναι η προκαθορισμένη σελίδα που θα βλέπουν οι χρήστες όταν επισκέπτονται το site σας και θα πρέπει να είναι ένα <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Αρχική Σελίδα',
'MultiLang'						=> 'Πολυγλωσσική Υποστήριξη',
'MultiLangDesc'					=> 'Η πολυγλωσσική υποστήριξη σας επιτρέπει να έχετε σελίδες με διαφορετικές γλωσσικές ρυθμίσεις μέσα σε μία μόνη εγκατάσταση. Εάν αυτή η επιλογή είναι ενεργοποιημένη, τότε το πρόγραμμα εγκατάστασης θα δημιουργήσει αρχικές αντικείμενα μενού για όλες τις διαθέσιμες γλώσσες στην διανομή.',
'AllowedLang'					=> 'Επιτρεπόμενες Γλώσσες',
'AllowedLangDesc'				=> 'Συνιστάται να επιλέξετε μόνο το σύνολο των γλωσσών που θέλετε να χρησιμοποιήσετε, άλλες σοφές επιλέγονται όλες οι γλώσσες.',
'Admin'							=> 'Όνομα Διαχειριστή',
'AdminDesc'						=> 'Εισάγεται το όνομα του διαχειριστή, αυτό πρέπει να είναι ένα <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Το όνομα μέλους πρέπει να είναι από %1 έως %2 χαρακτήρες μακρύ και να περιέχει μόνο αλφαριθμητικούς χαρακτήρες.',
'NameCamelCaseOnly'				=> 'Το όνομα χρήστη πρέπει να είναι μεταξύ %1 και %2 χαρακτήρων και να έχει WikiName μορφοποίηση.',
'Password'						=> 'Συνθηματικό Διαχειριστή',
'PasswordDesc'					=> 'Επέλεξε ένα συνθηματικό για τον διαχειριστή με τουλάχιστον %1 χαρακτήρες.',
'PasswordConfirm'				=> 'Επανέλαβε το συνθηματικό:',
'Mail'							=> 'Ηλεκτρονική Διεύθυνση Διαχειριστή',
'MailDesc'						=> 'Εισήγαγε την ηλεκτρονική διεύθυνση του διαχειριστή.',
'Base'							=> 'Βασικό URL',
'BaseDesc'						=> 'Το βασικό URL των WackoWiki sites σας. Τα ονόματα των σελίδων θα εξαρτώνται από αυτό, ώστε όταν θα χρησιμοποιείτε το mod_rewrite η διεύθυνση θα τελειώνει με μία κάθετο π.χ.',
'Rewrite'						=> 'Κατάσταση Επανεγγραφής',
'RewriteDesc'					=> 'Η κατάσταση επανεγγραφής θα ενεργοποιηθεί εάν χρησιμοποιείται το WackoWiki με την επανεγγραφή URL.',
'Enabled'						=> 'Ενεργοποίηση:',
'ErrorAdminEmail'				=> 'Δεν έχετε εισάγει μία έγκυρη ηλεκτρονική διεύθυνση!',
'ErrorAdminPasswordMismatch'	=> 'Τα συνθηματικά ΔΕΝ ταιριάζουν!.',
'ErrorAdminPasswordShort'		=> 'Το συνθηματικό του διαχειριστή είναι πολύ μικρό, το ελάχιστο μήκος είναι %1 χαρακτήρες!',
'ModRewriteStatusUnknown'		=> 'Το πρόγραμμα εγκατάστασης δεν μπορεί να επιβεβαιώσει ότι το mod_rewrite είναι ενεργοποιημένο, παρόλα αυτά αυτό δεν σημαίνει ότι είναι απενεργοποιημένο',

/*
   Database Config Page
*/
'config-database'				=> 'Ρυθμίσεις Βάσης',
'DbDriver'						=> 'Οδηγός',
'DbDriverDesc'					=> 'Ο οδηγός της βάσης που θέλετε να χρησιμοποιήσετε.',
'DbSqlMode'						=> 'Λειτουργία SQL',
'DbSqlModeDesc'					=> 'Η λειτουργία SQL που θέλετε να χρησιμοποιήσετε.',
'DbVendor'						=> 'Προμηθευτής',
'DbVendorDesc'					=> 'Ο προμηθευτής βάσης δεδομένων που χρησιμοποιείτε.',
'DbCharset'						=> 'Κωδικοποίηση χαρακτήρων',
'DbCharsetDesc'					=> 'Η βάση κωδικοποίησης χαρακτήρων που θέλετε να χρησιμοποιήσετε.',
'DbEngine'						=> 'Μηχανή',
'DbEngineDesc'					=> 'Η μηχανή βάσης δεδομένων που θέλετε να χρησιμοποιήσετε.',
'DbHost'						=> 'Διακομιστής',
'DbHostDesc'					=> 'Το όνομα του διακομιστή βάσεων δεδομένων που τρέχει σε αυτό. Συνήθως είναι <code>127.0.0.1</code> ή <code>localhost</code> (π.χ., το ίδιο όνομα που είναι το WackoWiki site σας).',
'DbPort'						=> 'Πόρτα (Προαιρετικό)',
'DbPortDesc'					=> 'Ο αριθμός της πόρτας του διακομιστή βάσεων δεδομένων σας αν είναι προσβάσιμος σε αυτή, αφήστε το κενό εάν χρησιμοποιείτε τον προκαθορισμένο αριθμό πόρτας.',
'DbName'						=> 'Το όνομα της Βάσης',
'DbNameDesc'					=> 'Η βάση δεδομένων που θα χρησιμοποιήσει το WackoWiki. Αυτή η βάση πρέπει να υπάρχει ήδη για να προχωρήσουμε!',
'DbUser'						=> 'Όνομα Χρήστη',
'DbUserDesc'					=> 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'DbPassword'					=> 'Συνθηματικό',
'DbPasswordDesc'				=> 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'Prefix'						=> 'Πρόθεμα Πίνακα',
'PrefixDesc'					=> 'Πρόθεμα όλων των πινάκων που χρησιμοποιούνται από το WackoWiki. Αυτό σας επιτρέπει να τρέχετε πολλαπλές εγκαταστάσεις του WackoWiki χρησιμοποιώντας την ίδια βάση δεδομένων ρυθμίζοντας διαφορετικά προθέματα στους πίνακες (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ είτε ενεργοποιήστε μία εκ των επεκτάσεων mysqli ή pdo_mysql στο php.ini αρχείο σας.',
'ErrorNoDbDriverSelected'		=> 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ επιλέξτε έναν από την λίστα.',
'DeleteTables'					=> 'Διαγραφή υπαρχόντων πινάκων?',
'DeleteTablesDesc'				=> 'ΠΡΟΣΟΧΗ! Εάν προχωρήσετε με αυτή την επιλογή επιλεγμένη, όλα τα τρέχοντα δεδομένα του wiki θα διαγραφούν από τη βάση δεδομένων σας. Αυτό δεν μπορεί να αναιρεθεί, εκτός αν επαναφέρετε τα δεδομένα χειροκίνητα από ένα αντίγραφο ασφαλείας.',
'ConfirmTableDeletion'			=> 'Είστε σίγουροι ότι θέλετε να διαγράψετε όλους τους τρέχοντες πίνακες wiki?',

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
'ErrorDatabaseVersion'			=> 'Η έκδοση της βάσης δεδομένων είναι %1 αλλά απαιτεί τουλάχιστον %2.',
'To'							=> 'στο',
'AlterTable'					=> 'Αλλαγή του %1 Πίνακα',
'InsertRecord'					=> 'Εισαγωγή εγγραφής στον πίνακα %1',
'RenameTable'					=> 'Μετονομασία πίνακα %1',
'UpdateTable'					=> 'Ενημέρωση πίνακα %1',
'InstallDefaultData'			=> 'Προσθήκη Προκαθορισμένων Δεδομένων',
'InstallPagesBegin'				=> 'Προσθήκη Προκαθορισμένων Σελίδων',
'InstallPagesEnd'				=> 'Ολοκλήρωση Προσθήκης Προκαθορισμένων Σελίδων',
'InstallSystemAccount'			=> 'Προσθήκη χρήστη <code>System</code>',
'InstallDeletedAccount'			=> 'Προσθήκη χρήστη <code>Deleted</code>',
'InstallAdmin'					=> 'Προσθήκη Χρήση Διαχειριστή',
'InstallAdminSetting'			=> 'Προσθήκη Χρήση Διαχειριστή',
'InstallAdminGroup'				=> 'Προσθήκη Ομάδας Διαχειριστών',
'InstallAdminGroupMember'		=> 'Προσθήκη Μέλους Ομάδας Διαχειριστών',
'InstallEverybodyGroup'			=> 'Προσθήκη Όλων των Ομάδων',
'InstallModeratorGroup'			=> 'Προσθήκη Ομάδας Συντονιστή',
'InstallReviewerGroup'			=> 'Προσθήκη Ομάδας Επισκόπησης',
'InstallLogoImage'				=> 'Προσθήκη Εικόνας Λογότυπο',
'LogoImage'						=> 'Εικόνα λογότυπου',
'InstallConfigValues'			=> 'Προσθήκη Τιμών Ρυθμίσεων',
'ConfigValues'					=> 'Τιμές Ρυθμίσεων',
'ErrorInsertPage'				=> 'Σφάλμα κατά την εισαγωγή της %1 σελίδας',
'ErrorInsertPagePermission'		=> 'Σφάλμα ρύθμισης δικαιώματος για την %1 σελίδα',
'ErrorInsertDefaultMenuItem'	=> 'Σφάλμα ρύθμισης της σελίδας %1 ως προεπιλεγμένο στοιχείο μενού',
'ErrorPageAlreadyExists'		=> 'Η %1 σελίδα ήδη υπάρχει',
'ErrorAlterTable'				=> 'Σφάλμα αλλαγής %1 πίνακα',
'ErrorInsertRecord'				=> 'Σφάλμα εισαγωγής εγγραφής στον πίνακα %1',
'ErrorRenameTable'				=> 'Σφάλμα μετονομασίας πίνακα %1',
'ErrorUpdatingTable'			=> 'Σφάλμα κατά την ενημέρωση %1 πίνακα',
'CreatingTable'					=> 'Δημιουργία πίνακα: %1',
'ErrorAlreadyExists'			=> 'Ο %1 υπάρχει ήδη',
'ErrorCreatingTable'			=> 'Σφάλμα κατά την δημιουργία του πίνακα: %1, δεν υπάρχει ήδη;',
'DeletingTables'				=> 'Διαγραφή πινάκων',
'DeletingTablesEnd'				=> 'Ολοκλήρωση Διαγραφής Πινάκων',
'ErrorDeletingTable'			=> 'Σφάλμα κατά τη διαγραφή του πίνακα %1, ο πιθανότερος λόγος είναι ότι ο πίνακας δεν υπάρχει σε αυτή την περίπτωση μπορείτε να αγνοήσετε αυτή την προειδοποίηση.',
'DeletingTable'					=> 'Διαγραφή %1 πίνακα',
'NextStep'						=> 'Στο επόμενο βήμα, το πρόγραμμα εγκατάστασης θα προσπαθήσει να γράψει το ανανεωμένο αρχείο ρυθμίσεων, %1. Παρακαλώ σιγουρευτείται ότι ο web server σας έχει δικαίωμα πρόσβασης εγγραφής στο αρχείο, αλλιώς θα χρειαστεί να το επεξεργαστείται με το χέρι. Ακόμα μία φορά, δείτε για λεπτομέρειες εδώ: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',

/*
   Write Config Page
*/
'write-config'					=> 'Εγγραφή Αρχείου Ρυθμίσεων',
'FinalStep'						=> 'Τελικό Βήμα',
'Writing'						=> 'Εγγραφή Αρχείου Ρυθμίσεων',
'RemovingWritePrivilege'		=> 'Αφαίρεση Δικαιώματος Εγγραφής',
'InstallationComplete'			=> 'Η Εγκατάσταση Ολοκληρώθηκε',
'ThatsAll'						=> 'Αυτό ήταν όλο! Μπορείτε τώρα <a href="%1"> να δείτε το WackoWiki site σας</a>.',
'SecurityConsiderations'		=> 'Προτάσεις Ασφάλειας',
'SecurityRisk'					=> 'Σας προτείνεται να αφαιρέσετε το δικαίωμα εγγραφής στο %1 τώρα που έχει γραφτεί. Αφήνοντάς το αρχείο εγγράψιμο μπορεί να αποτελεί ρίσκο ασφάλειας!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Θα πρέπει να διαγράψετε τον κατάλογο %1 τώρα που η διαδικασία εγκατάστασης έχει ολοκληρωθεί.',
'ErrorGivePrivileges'			=> 'Το αρχείο ρυθμίσεων %1 δεν πρέπει να είναι εγγράψιμο. Θα χρειαστεί να δώσετε στον web server σας προσωρινή πρόσβαση ώστε να γράψει είτε στον κατάλογο του WackoWiki, ή ένα κενό αρχείο με όνομα %1<br>%2<br><br>; μην ξεχάσετε να αφαιρέσετε το δικαίωμα εγγραφής αργότερα, π.χ. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Αν, για κάποιο λόγο, δεν μπορείτε να το κάνετε, θα πρέπει να αντιγράψετε το παρακάτω κείμενο σε ένα νέο αρχείο και να το αποθηκεύσετε/ανεβάσετε ως %1 μέσα στον κατάλογο του WackoWiki. Όταν το κάνετε αυτόμ το WackoWiki site σας θα δουλέψει. Εάν όχι, παρακαλώ επισκεφτείται το <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Όταν το κάνετε αυτόμ το WackoWiki site σας θα δουλέψει. Εάν όχι, παρακαλώ επισκεφτείται το <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'WrittenAt'						=> 'εγγράψιμο στις ',
'DontChange'					=> 'μην αλλάξετε την έκδοση του wacko_version με το χέρι!',
'ConfigDescription'				=> 'λεπτομερής περιγραφή https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Δοκιμάστε Πάλι',

];
