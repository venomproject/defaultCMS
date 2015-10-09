<?php
class Contact extends TPage
{
	public $Site;
	public function onLoad($param)
	{
		parent::onLoad($param);
		$this->Site = PagesRecord::finder()->findByPk(8);
		$this->confirmLabel->setCssClass ( 'alertMessage' );
	}
	
	
	public function sendMessage($sender,$param)
	{
		diE();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
		$headers .= "From: AquaProjekt <kontakt@ledwood.pl>\r\n";
		$subject = "Fromularz kontaktowy : AquaProjekt";
		 $to = $this->Email->SafeText.', kontakt@aquaprojekt.pl';
		$tresc = "
		imię i nazwisko / firma : ".$this->Name->SafeText."
		mail : ".$this->Email->SafeText."
		treść : ".$this->Message->SafeText."
			
		";
		
		die();
	
		$this->confirmLabel->setVisible ( true );
		if( @mail($to, $subject , $tresc, $headers ) ) {
			$this->confirmLabel->Text = 'Wiadomość została wysłana';
			$this->confirmLabel->setForeColor('green');
		}
		else{
			$this->confirmLabel->Text = 'Wiadomość nie mogła zostać wysłana.';
		$this->confirmLabel->setForeColor('red');	
		}
		$this->Name->Visible = true;
		$this->Email->Visible = true;
		$this->Message->Visible = true;
		
		
		$this->Name->Text = '';
		$this->Email->Text = '';
		$this->Message->Text = '';
	}
}
?>