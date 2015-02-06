<?php
	use \AF\Database;
	
	$companys = Database::fetch('SELECT * FROM `af_companys`');
	
	foreach($companys AS $index => $company) {
		$companys[$index]->contacts = Database::fetch('SELECT * FROM `af_companys_contacts` WHERE `company_id`=:company_id', array(
			'company_id'	=> $company->id
		));
	}
	
	$template->assign('companys', $companys);
?>