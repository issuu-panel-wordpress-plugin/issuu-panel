<?php

class IssuuPanelPluginManager
{
	private $issuuPanelHookManager;

	private $issuuPanelOptionEntity;

	private $issuuPanelConfig;

	private $issuuPanelOptionEntityManager;

	public function __construct()
	{
		$this->initListeners();
		$this->issuuPanelOptionEntityManager = new IssuuPanelOptionEntityManager();
		$this->issuuPanelOptionEntity = $this->getOptionEntityManager()->getOptionEntity();
		$this->issuuPanelConfig = new IssuuPanelConfig(
			$this->issuuPanelOptionEntity,
			$this->issuuPanelOptionEntityManager
		);
		$this->issuuPanelHookManager = $this->issuuPanelConfig->getHookManager();
		$this->initPlugin();
		$this->initMenus();
		$this->initShortcodes();
		$this->initWidgets();
		$this->getHookManager()->triggerAction(
			'on-construct-issuu-panel-plugin-manager',
			$this,
			array(
				'entity' => $this->issuuPanelOptionEntity,
				'config' => $this->issuuPanelConfig,
			)
		);
	}

	public function __destruct()
	{
		$this->getHookManager()->triggerAction(
			'on-destruct-issuu-panel-plugin-manager',
			$this,
			array(
				'config' => $this->issuuPanelConfig,
			)
		);
	}

	public function getOptionEntityManager()
	{
		return $this->issuuPanelOptionEntityManager;
	}

	public function getHookManager()
	{
		return $this->issuuPanelHookManager;
	}

	public function initPlugin()
	{
		$initPlugin = new IssuuPanelInitPlugin();
		$initPlugin->setConfig($this->issuuPanelConfig);
		$scripts = new IssuuPanelScripts();
		$scripts->setConfig($this->issuuPanelConfig);
		$tinymce = new IssuuPanelTinyMCEButton();
		$tinymce->setConfig($this->issuuPanelConfig);
	}

	private function initListeners()
	{
		new IssuuPanelDocumentListener();
		new IssuuPanelUpdateDataListener();
		new IssuuPanelPluginConfigListener();
	}

	private function initMenus()
	{
		$main = new IssuuPanelMenu();
		$main->setConfig($this->issuuPanelConfig);

		$document = new IssuuPageDocuments();
		$document->setConfig($this->issuuPanelConfig);

		$folder = new IssuuPanelFolders();
		$folder->setConfig($this->issuuPanelConfig);

		$about = new IssuuPageAbout();
		$about->setConfig($this->issuuPanelConfig);
	}

	private function initShortcodes()
	{
		$shortcode = new IssuuPanelShortcodes();
		$shortcode->setConfig($this->issuuPanelConfig);
	}

	private function initWidgets()
	{

	}
}