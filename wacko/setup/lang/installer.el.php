<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-7',
'LangISO' => 'el',
'LangName' => 'Greek',

/*
   Generic Page Text
*/
'Title' => 'Εγκατάσταση WackoWiki',
'Continue' => 'Συνέχεια',
'Back' => 'Επιστροφή',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Παρακαλώ, πάρτε αντίγραφο της βάσης, του αρχείου ρυθμίσεων και όλα τα τροποποιημένα αρχεία όπως αυτά που έχουν αλλαγές σε κώδικα και προσθήκες επιρραμάτων πριν την εκκίνηση της διαδικασίας ανάβάθμισης. Αυτό θα σας προτρέψει από έναν μεγάλο πονοκέφαλο.',
'Lang' => 'Ρυθμίσεις Γλώσσας',
'LangDesc' => 'Παρακαλώ επιλέξτε μια γλώσσα για την διαδικασία εγκατάστασης. Η γλώσσα αυτή θα χρησιμοποιηθεί επίσης και ως προκαθορισμένη γλώσσα για την εγκατάσταση του WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Απαιτήσεις Συστήματος',
'PHPVersion' => 'Έκδοση PHP',
'PHPDetected' => 'Εντοπίστηκε PHP',
'ModRewrite' => 'Apache Rewrite Extension (Προαιρετικό)',
'ModRewriteInstalled' => 'Εγκατεστημένο Rewrite Extension (mod_rewrite);',
'Database' => 'Βάση Δεδομένων',
'Permissions' => 'Δικαιώματα',
'ReadyToInstall' => 'Έτοιμοι για εγκατάσταση;',
'Requirements' => 'Ο διακομιστής πρέπει να έχει τις παρακάτω σε λίστα απαιτήσεις.',
'OK' => 'OK',
'Problem' => 'Πρόβλημα',
'NotePermissions' => 'Το πρόγραμμα εγκατάστασης θα προσπαθήσεις να γράψει δεδομένα ρυθμίσεων στο αρχείο <tt>config.php</tt>, το οποίο βρίσκετε στον κατάλογο του WackoWiki. Για να δουλέψει αυτό, πρέπει να βεβαιωθείτε ότι ο web server σας μπορεί να γράψει σε αυτό το αρχείο. Εάν δεν μπορεί να το κάνει αυτό, θα πρέπει να το επεξεργαστείτε με το χέρι (το πρόγραμμα εγκατάστασης θα σας πει πως).<br /><br />Δείτε <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> για λεπτομέρειες.',
'ErrorPermissions' => 'Όπως φαίνεται το πρόγραμμα εγκατάστασης δεν μπορεί αυτόματα να θέσει τις απαιτήσεις στα δικαιώματα αρχείων για το WackoWiki να δουλέψει σωστά. Θα προταθείτε αργότερα κατά την διαδικασία εγκατάστασης να τροποποιήσετε με το χέρι τις απαιτήσεις στα δικαιώματα των αρχείων στον διακομιστή σας.',
'ErrorMinPHPVersion' => 'Η έκδοση της PHP πρέπει να είναι μεγαλύτερη της <strong>5.2.0</strong>, ο διακομιστής σας φαίνεται να τρέχει σε προηγούμενη έκδοση. Πρέπει να αναβαθμίσετε σε μία πιο πρόσφατη PHP έκδοση για δουλέψει σωστά το WackoWiki.',
'Ready' => 'Συγχαρητήρια, διαπιστώνεται ότι ο διακομιστής σας μπορεί να τρέξει το WackoWiki.
Οι επόμενες σελίδες θα σας περιηγήσουν στην διαδικασία παραμετροποίησης.',

/*
   Site Config Page
*/
'site-config' => 'Παραμετροποίηση Site',
'Name' => 'Όνομα του WackoWiki',
'NameDesc' => 'Παρακαλώ εισάγεται ένα όνομα για το WackoWiki site σας, αυτό πρέπει να είναι
της μορφής <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Αρχική Σελίδα',
'HomeDesc' => 'Πληκτρολογήστε το όνομα που θέλετε να έχει η αρχική σελίδα σας, αυτή θα είναι η προκαθορισμένη σελίδα που θα βλέπουν οι χρήστες όταν επισκέπτονται το site σας και θα πρέπει να είναι ένα <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Πολυγλωσσική Υποστήριξη',
'MultiLangDesc' => 'Η πολυγλωσσική υποστήριξη σας επιτρέπει να έχετε σελίδες με διαφορετικές γλωσσικές ρυθμίσεις μέσα σε μία μόνη εγκατάσταση. Εάν αυτή η επιλογή είναι ενεργοποιημένη, τότε το πρόγραμμα εγκατάστασης θα δημιουργήσει αρχικές σελίδες για όλες τις διαθέσιμες γλώσσες στην διανομή.',
'Admin' => 'Όνομα Διαχειριστή',
'AdminDesc' => 'Εισάγεται το όνομα του διαχειριστή, αυτό πρέπει να είναι ένα <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. WikiAdmin).',
'Password' => 'Συνθηματικό Διαχειριστή',
'PasswordDesc' => 'Επέλεξε ένα συνθηματικό για τον διαχειριστή με τουλάχιστον 8 χαρακτήρες.',
'Password2' => 'Επανέλαβε το συνθηματικό:',
'Mail' => 'Ηλεκτρονική Διεύθυνση Διαχειριστή',
'MailDesc' => 'Εισήγαγε την ηλεκτρονική διεύθυνση του διαχειριστή.',
'Base' => 'Βασικό URL',
'BaseDesc' => 'Το βασικό URL των WackoWiki sites σας. Τα ονόματα των σελίδων θα εξαρτώνται από αυτό, ώστε όταν θα χρησιμοποιείτε το mod_rewrite η διεύθυνση θα τελειώνει με μία κάθετο π.χ.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Κατάσταση Επανεγγραφής',
'RewriteDesc' => 'Η κατάσταση επανεγγραφής θα ενεργοποιηθεί εάν χρησιμοποιείται το WackoWiki με την επανεγγραφή URL.',
'Enabled' => 'Ενεργοποίηση:',
'ErrorAdminName' => 'Το όνομα του διαχειριστή πρέπει να είναι ένα WikiName!',
'ErrorAdminEmail' => 'Δεν έχετε εισάγει μία έγκυρη ηλεκτρονική διεύθυνση!',
'ErrorAdminPasswordMismatch' => 'Τα συνθηματικά ΔΕΝ ταιριάζουν!.',
'ErrorAdminPasswordShort' => 'Το συνθηματικό του διαχειριστή είναι πολύ μικρό, το ελάχιστο μήκος είναι 8 χαρακτήρες!',
'WarningRewriteMode' => 'ΠΡΟΣΟΧΗ!\nΤο βασικό σας URL και η ρύθμιση της κατάστασης επανεγγραφής φαίνονται ύποπτα. Συνήθως ΔΕΝ υπάρχει σημάδι ? στο βασικό URL όταν η κατάσταση επανεγγραφής έχει τεθεί - αλλά στην περίπτωσή σας υπάρχει.\n\nΓια να συνεχίσετε με αυτές τις ρυθμίσεις πατήστε το OK.\nΓια να επιστρέψετε στην φόρμα και να αλλάξετε τις ρυθμίσεις σας πατήστε το CANCEL(ακύρωση).\n\nΑν είστε έτοιμοι να προχωρήσετε με αυτές τις ρυθμίσεις, παρακαλώ να σημειωθεί ότι ΜΠΟΡΕΙ να δημιουργηθούν προβλήματα με την εγκατάσταση του WackoWiki.',
'ModRewriteStatusUnknown' => 'Το πρόγραμμα εγκατάστασης δεν μπορεί να επιβεβαιώσει ότι το mod_rewrite είναι ενεργοποιημένο, παρόλα αυτά αυτό δεν σημαίνει ότι είναι απενεργοποιημένο',

/*
   Database Config Page
*/
'database-config' => 'Ρυθμίσεις Βάσης',
'DBDriverDesc' => '
Ο οδηγός της βάσης που θέλετε να χρησιμοποιήσετε. Θα πρέπει να είναι ένας παραδοσιακός οδηγός εάν δεν έχετε PHP5.1 (ή μεγαλύτερη) και εγκατεστημένο <a href="http://gr.php.net/pdo" target="_blank">PDO</a>.',
'DBDriver' => 'Οδηγός',
'DBHost' => 'Διακομιστής',
'DBHostDesc' => 'Το όνομα του διακομιστή βάσεων δεδομένων που τρέχει σε αυτό. Συνήθως είναι "localhost" (π.χ., το ίδιο όνομα που είναι το WackoWiki site σας).',
'DBPort' => 'Πόρτα (Προαιρετικό)',
'DBPortDesc' => 'Ο αριθμός της πόρτας του διακομιστή βάσεων δεδομένων σας αν είναι προσβάσιμος σε αυτή, αφήστε το κενό εάν χρησιμοποιείτε
τον προκαθορισμένο αριθμό πόρτας.',
'DB' => 'Το όνομα της Βάσης',
'DBDesc' => 'Η βάση δεδομένων που θα χρησιμοποιήσει το WackoWiki. Αυτή η βάση πρέπει να υπάρχει ήδη για να προχωρήσουμε!',
'DBUserDesc' => 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'DBUser' => 'Όνομα Χρήστη',
'DBPasswordDesc' => 'Το όνομα και το συνθηματικό του χρήστη που χρησιμοποιείται για να συνδέεστε στην βάση σας.',
'DBPassword' => 'Συνθηματικό',
'PrefixDesc' => 'Πρόθεμα όλων των πινάκων που χρησιμοποιούνται από το WackoWiki. Αυτό σας επιτρέπει να τρέχετε πολλαπλές εγκαταστάσεις του WackoWiki χρησιμοποιώντας την ίδια βάση δεδομένων ρυθμίζοντας διαφορετικά προθέματα στους πίνακες (e.g. wacko_).',
'Prefix' => 'Πρόθεμα Πίνακα',
'ErrorNoDbDriverDetected' => 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ είτε ενεργοποιήστε μία εκ των επεκτάσεων mysql, mysqli ή pdo στο php.ini αρχείο σας.',
'ErrorNoDbDriverSelected' => 'Δεν εντοπίστηκε οδηγός βάσεων δεδομένων, παρακαλώ επιλέξτε έναν από την λίστα.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Εγκατάσταση Βάσης',
'TestingConfiguration' => 'Έλεγχος Ρυθμίσεων',
'TestConnectionString' => 'Έλεγχος ρυθμίσεων σύνδεσης με την βάση δεδομένων',
'TestDatabaseExists' => 'Δοκιμή εάν η βάση δεδομένων που δηλώσατε υπάρχει',
'InstallingTables' => 'Εγκατάσταση πινάκων',
'ErrorDBConnection' => 'Υπήρξε ένα πρόβλημα με τις λεπτομέρειες που δώσατε για την σύνδεση με την βάση δεδομένων, παρακαλώ επιστρέψτε και ελέγξετε ότι είναι σωστά.',
'ErrorDBExists' => 'Η βάση δεδομένων που έχετε ρυθμίσει δεν βρέθηκε. Θυμηθείτε, χρειάζεται να υπάρχει πριν από την εγκατάσταση/αναβάθμιση του WackoWiki!',
'To' => 'στο',
'AlterTable' => 'Αλλαγή του <tt>%1</tt> Πίνακα',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Προσθήκη Προκαθορισμένων Δεδομένων',
'InstallingPagesBegin' => 'Προσθήκη Προκαθορισμένων Σελίδων',
'InstallingPagesEnd' => 'Ολοκλήρωση Προσθήκης Προκαθορισμένων Σελίδων',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Προσθήκη Χρήση Διαχειριστή',
'InstallingAdminSetting' => 'Προσθήκη Χρήση Διαχειριστή',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Προσθήκη Εικόνας Λογότυπο',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Σφάλμα κατά την εισαγωγή της <tt>%1</tt> σελίδας',
'ErrorInsertingPageReadPermission' => 'Σφάλμα ρύθμισης δικαιώματος ανάγνωσης για την <tt>%1</tt> σελίδα',
'ErrorInsertingPageWritePermission' => 'Σφάλμα ρύθμισης δικαιώματος εγγραφής για την <tt>%1</tt> σελίδα',
'ErrorInsertingPageCommentPermission' => 'Σφάλμα ρύθμισης δικαιώματος σχόλιου για την <tt>%1</tt> σελίδα',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'Η <tt>%1</tt> σελίδα ήδη υπάρχει',
'ErrorAlteringTable' => 'Σφάλμα αλλαγής <tt>%1</tt> πίνακα',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Δημιουργία πίνακα: <tt>%1</tt>',
'ErrorAlreadyExists' => 'Ο <tt>%1</tt> υπάρχει ήδη',
'ErrorCreatingTable' => 'Σφάλμα κατά την δημιουργία του πίνακα: <tt>%1</tt>, δεν υπάρχει ήδη;',
'ErrorMovingRevisions' => 'Σφάλμα μετακίνησης δεδομένων έκδοσης',
'MovingRevisions' => 'Μετακίνηση δεδομένων σε πίνακα έκδοσης',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

/*
   Write Config Pageς
*/
'write-config' => 'Εγγραφή Αρχείου Ρυθμίσεων',
'FinalStep' => 'Final Step',
'Writing' => 'Εγγραφή Αρχείου Ρυθμίσεων',
'RemovingWritePrivilege' => 'Αφαίρεση Δικαιώματος Εγγραφής',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => 'Αυτό ήταν όλο! Μπορείτε τώρα <a href="%1"> να δείτε το WackoWiki site σας</a>.',
'SecurityConsiderations' => 'Προτάσεις Ασφάλειας',
'SecurityRisk' => 'Σας προτείνεται να αφαιρέσετε το δικαίωμα εγγραφής στο <tt>config.php</tt> τώρα που έχει γραφτεί. Αφήνοντάς το αρχείο εγγράψιμο μπορεί να αποτελεί ρίσκο ασφάλειας!',
'RemoveSetupDirectory' => 'Θα πρέπει να διαγράψετε τον κατάλογο "setup" τώρα που η διαδικασία εγκατάστασης έχει ολοκληρωθεί.',
'ErrorGivePrivileges' => 'Το αρχείο ρυθμίσεων <tt>%1</tt> δεν πρέπει να είναι εγγράψιμο. Θα χρειαστεί να δώσετε στον web server σας προσωρινή πρόσβαση ώστε να γράψει είτε στον κατάλογο του WackoWiki, ή ένα κενό αρχείο με όνομα <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; μην ξεχάσετε να αφαιρέσετε το δικαίωμα εγγραφής αργότερα, π.χ. <tt>chmod 644 config.php</tt>). Αν, για κάποιο λόγο, δεν μπορείτε να το κάνετε, θα πρέπει να αντιγράψετε το παρακάτω κείμενο σε ένα νέο αρχείο και να το αποθηκεύσετε/ανεβάσετε ως <tt>config.php</tt> μέσα στον κατάλογο του WackoWiki. Όταν το κάνετε αυτόμ το WackoWiki site σας θα δουλέψει. Εάν όχι, παρακαλώ επισκεφτείται το <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Στο επόμενο βήμα, το πρόγραμμα εγκατάστασης θα προσπαθήσει να γράψει το ανανεωμένο αρχείο ρυθμίσεων, <tt>config.php</tt>.
Παρακαλώ σιγουρευτείται ότι ο web server σας έχει δικαίωμα πρόσβασης εγγραφής στο αρχείο, αλλιώς θα χρειαστεί να το επεξεργαστείται με το χέρι.
Ακόμα μία φορά, δείτε για λεπτομέρειες εδώ: <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt' => 'εγγράψιμο στις ',
'DontChange' => 'μην αλλάξετε την έκδοση του wacko_version με το χέρι!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Δοκιμάστε Πάλι',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>