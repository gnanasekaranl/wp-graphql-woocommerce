<?php
/**
 * Model - WC_Post
 *
 * Models WooCommerce post-type data
 *
 * @package WPGraphQL\Extensions\WooCommerce\Model
 * @since 0.0.1
 */

namespace WPGraphQL\Extensions\WooCommerce\Model;

use GraphQLRelay\Relay;
use WPGraphQL\Data\DataSource;
use WPGraphQL\Model\Post;

/**
 * Class WC_Post
 *
 * @property int     $ID
 * @property int     $this->wc_postId
 * @property string  $code
 * @property string  $date
 * @property string  $modified
 * @property string  $description
 * @property string  $discountType
 * @property string  $amount
 * @property string  $dateExpiry
 * @property string  $usageCount
 * @property boolean $individualUse
 * @property int     $usageLimit
 * @property int     $usageLimitPerUser
 * @property int     $limitUsageToXItems
 * @property boolean $freeShipping
 * @property boolean $excludeSaleItems
 * @property float   $minimumAmount
 * @property float   $maximumAmount
 * @property array   $emailRestrictions
 */
class WC_Post extends Post {
	/**
	 * Stores the instance of WC_Coupon
	 *
	 * @var \WC_Coupon $this->wc_post
	 */
	protected $wc_post;

	/**
	 * Coupon constructor
	 *
	 * @param \WC_Coupon $this->wc_post
	 *
	 * @access public
	 * @return void
	 * @throws \Exception
	 */
	public function __construct( \WP_Post $post ) {
		$this->wc_post = $this->get_wc_post( $post );
		parent::__construct( $post );
	}

	private function get_wc_post( $post ) {
		switch( $post->post_type ) {
			case 'shop_coupon':
				return new \WC_Coupon( $post->ID );
			case 'shop_order':
				return new \WC_Order( $post->ID );
			case 'shop_order_refund':
				return new \WC_Order_Refund( $post->ID );
			case 'product':
			case 'product_variation':
				return \wc_get_product( $post->ID );
		}
	}

	public function init() {
		if ( 'private' === parent::get_visibility() ) {
			return null;
		}

		if ( empty( $this->fields ) ) {
			parent::init();

			if( 'shop_coupon' === $this->post->post_type ) {
				$this->fields = array_merge(
					$this->fields,
					array(
						'code'               => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_code() : null;
						},
						'date'               => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_date_created() : null;
						},
						'modified'           => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_date_modified() : null;
						},
						'description'        => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_description() : null;
						},
						'discountType'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_discount_type() : null;
						},
						'amount'             => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_amount() : null;
						},
						'dateExpiry'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_date_expires() : null;
						},
						'usageCount'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_usage_count() : null;
						},
						'individualUse'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_individual_use() : null;
						},
						'usageLimit'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_usage_limit() : null;
						},
						'usageLimitPerUser'  =>  function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_usage_limit_per_user() : null;
						},
						'limitUsageToXItems' => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_limit_usage_to_x_items() : null;
						},
						'freeShipping'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_free_shipping() : null;
						},
						'excludeSaleItems'   => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_exclude_sale_items() : null;
						},
						'minimumAmount'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_minimum_amount() : null;
						},
						'maximumAmount'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_maximum_amount() : null;
						},
						'emailRestrictions'  => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_email_restrictions() : null;
						},
					)
				);
			}
			if( 'product' === $this->post->post_type || 'product_variation' === $this->post->post_type ) {
				$this->fields = array_merge(
					$this->fields,
					array(
						'slug'              => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_slug() : null;
						},
						'name'              => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_name() : null;
						},
						'status'            => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_status() : null;
						},
						'featured'          => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_featured() : null;
						},
						'catalogVisibility' => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_catalog_visibility() : null;
						},
						'description'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_description() : null;
						},
						'shortDescription'  => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_short_description() : null;
						},
						'sku'               => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_sku() : null;
						},
						'price'             => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_price() : null;
						},
						'regularPrice'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_regular_price() : null;
						},
						'salePrice'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_sale_price() : null;
						},
						'dateOnSaleFrom'    => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_date_on_sale_from() : null;
						},
						'dateOnSaleTo'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_date_on_sale_to() : null;
						},
						'totalSales'        => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_total_sales() : null;
						},
						'taxStatus'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_tax_status() : null;
						},
						'taxClass'          => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_tax_class() : null;
						},
						'manageStock'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_manage_stock() : null;
						},
						'stockQuantity'     => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_stock_quantity() : null;
						},
						'stockStatus'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_stock_status() : null;
						},
						'backorders'        => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_backorders() : null;
						},
						'soldIndividually'  => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_sold_individually() : null;
						},
						'weight'            => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_weight() : null;
						},
						'length'            => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_length() : null;
						},
						'width'             => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_width() : null;
						},
						'height'            => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_height() : null;
						},
						'reviewsAllowed'    => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_reviews_allowed() : null;
						},
						'purchaseNote'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_purchase_note() : null;
						},
						'menuOrder'         => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_menu_order() : null;
						},
						'virtual'           => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_virtual() : null;
						},
						'downloadExpiry'    => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_download_expiry() : null;
						},
						'downloadable'      => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_downloadable() : null;
						},
						'downloadLimit'     => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_download_limit() : null;
						},
						'ratingCount'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_rating_counts() : null;
						},
						'averageRating'     => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_average_rating() : null;
						},
						'reviewCount'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_review_count() : null;
						},
						'parentId'       => function() {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_parent_id() : null;
						},
						'imageId'             => function () {
							return ! empty( $this->wc_post ) ? $this->wc_post->get_image_id(): null;
						},
					)
				);
			}

			parent::prepare_fields();
		}
	}

}