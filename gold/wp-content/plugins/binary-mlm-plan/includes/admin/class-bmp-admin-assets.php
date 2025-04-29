<?php

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('BMP_Admin_Assets', false)) :


	class BMP_Admin_Assets
	{

		/**
		 * Hook in tabs.
		 */
		public function __construct() {}

		public static function bmp_scripts()
		{

			add_action('admin_enqueue_scripts', array(BMP_Admin_Assets::class, 'admin_styles'));
			add_action('admin_enqueue_scripts', array(BMP_Admin_Assets::class, 'admin_scripts'));
		}

		/**
		 * Enqueue styles.
		 */
		public static function admin_styles()
		{


			wp_enqueue_style('bmp_admin_styles', BMP()->plugin_url() . '/assets/css/admin/admin.css', array(), time(), 'all');
			wp_enqueue_style('bmp_admin_bootstrap', BMP()->plugin_url() . '/assets/css/bootstrap.css', [], time(), 'all');
			wp_enqueue_style('bmp_fs_css', BMP()->plugin_url() . '/assets/fontawesome/css/all.min.css', [], true, 'all');
		}


		/**
		 * Enqueue scripts.
		 */
		public static function admin_scripts()
		{

			// Register scripts.
			wp_enqueue_script('jquery');
			wp_enqueue_script('bmp_admin_jquery', BMP()->plugin_url() . '/assets/js/admin/admin.js', array(), time(), false);
			wp_enqueue_style('bmp_admin_bootstrap', BMP()->plugin_url() . '/assets/js/bootstrap.js', [], time(), false);
			wp_enqueue_script('bmp-fs-js', BMP()->plugin_url() . '/assets/fontawesome/js/all.min.js', array(), time(), true);
		}
		public static function dataTableScript()
		{
			// Register scripts.
			// wp_enqueue_script('jquery');
			wp_enqueue_style('bmp_dataTable_css', BMP()->plugin_url() . '/assets/datatable/datatables.css', time(), 'all');
			wp_enqueue_script('bmp_dataTable_js', BMP()->plugin_url() . '/assets/datatable/datatables.js', ['jquery'], time(), true);
			wp_enqueue_script('bmp_dataTable', BMP()->plugin_url() . '/assets/js/dataTable.js', [], time(), false);
		}

		public static function admin_genealogy_scripts()
		{
			// Register scripts.
			$data = bmp_get_all_members_array();
			$data  = json_encode($data);
			wp_enqueue_style('bmp_admin_gene_css', BMP()->plugin_url() . '/assets/js/genealogy/genealogy.css', [], true, 'all');
			wp_enqueue_script('bmp-genboot-js', BMP()->plugin_url() . '/assets/js/genealogy/genealogy_boot.js', array('jquery'), time(), true);
			wp_enqueue_script('bmp-gen-js', BMP()->plugin_url() . '/assets/js/genealogy/genealogy_main.js', array('jquery'), time(), true);
			wp_localize_script('bmp-gen-js', 'genealogy_data', array($data));
		}
	}
endif;

// return new BMP_Admin_Assets();
