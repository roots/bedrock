<?php
	/**
	 * Created by PhpStorm.
	 * User: Andrelec1
	 * Date: 15/02/2017
	 * Time: 16:39
	 */

	namespace WonderWp\Theme\Components;


	class DownloadComponent extends AbstractComponent {

		protected $name;
		protected $filename;
		protected $link;
		protected $textDownload;
		protected $mini = false ;
		/**
		 * @return mixed
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @param mixed $name
		 *
		 * @return DownloadComponent
		 */
		public function setName( $name ) {
			$this->name = $name;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getFilename() {
			return $this->filename;
		}

		/**
		 * @param mixed $filename
		 *
		 * @return DownloadComponent
		 */
		public function setFilename( $filename ) {
			$this->filename = $filename;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getLink() {
			return $this->link;
		}

		/**
		 * @param mixed $link
		 *
		 * @return DownloadComponent
		 */
		public function setLink( $link ) {
			$this->link = $link;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getTextDownload() {
			return $this->textDownload;
		}

		/**
		 * @param mixed $textDownload
		 *
		 * @return DownloadComponent
		 */
		public function setTextDownload( $textDownload ) {
			$this->textDownload = $textDownload;

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function isMini() {
			return $this->mini;
		}

		/**
		 * @param mixed $mini
		 *
		 * @return DownloadComponent
		 */
		public function setMini( $mini = true ) {
			$this->mini = $mini;

			return $this;
		}



		public function getMarkup( $opts = [] ) {

			$makup = '<div class="download'.($this->isMini()?'': ' large').'">';
			$makup .='<div class="pdf"></div>';
			$makup .='<div class="info">';
			$makup .='<p class="title">'.$this->getName().'</p>';
			$makup .='<p class="filename">'.$this->getFilename().'</p>';
			if($this->isMini()){
				$makup .='<a href="'.$this->getLink().'">'.$this->getTextDownload().'</a>';
			}
			$makup .='</div>';
			if(!$this->isMini()) {
				$makup .= '<div class="link"><a href="' . $this->getLink() . '">' . $this->getTextDownload() . '</a></div>';
			}
			$makup .='</div>';


			return $makup;
		}
	}