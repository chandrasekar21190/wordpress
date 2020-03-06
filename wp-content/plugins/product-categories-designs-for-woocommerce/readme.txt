=== Product Categories Designs for WooCommerce ===
Contributors: wponlinesupport, anoopranawat, pratik-jain
Tags: categories designs, categories slider, categories grid, WooCommerce categories designs, WooCommerce categories slider, WooCommerce categories grid
Requires at least: 4.0
Tested up to: 5.3.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display WooCommerce product categories with good designs and grid and silder view. Also work with Gutenberg shortcode block.

== Description ==
Display WooCommerce product categories with good designs and grid and silder view. Added two designs ie design-1, design-2 work with both grid and slider.

Plugin add a sub tab under "Products --> Category Designs – How It Works" for more details.

Check [Demo and Features](https://demo.wponlinesupport.com/prodemo/product-categories-designs-for-woo-pro/) for additional information.

Try our new plugin [Woo Product Slider and Carousel with category](https://wordpress.org/plugins/woo-product-slider-and-carousel-with-category/)

Also work with Gutenberg shortcode block.

= This plugin contain 2 shortcode: =
1) Display WooCommerce **product categories in grid** view

<code>[wpos_product_categories]</code>

2) Display WooCommerce **product categories in slider / carousel view**

<code>[wpos_product_categories_slider]</code>


= You can use Following parameters with shortcode =

**Product Categories in Grid**

<code>[wpos_product_categories]</code>

* **columns:**
columns="4" (Display Number of Category Per Row. By Default value is 3. )
* **Design:**
design="design-2" (Design Number to Display your Product Category. Values are design-1 or design-2. By Default value is design-1.)
* **number:**
number="5" ( ie Display 5 product categories at time. By defoult value is all )
* **Order by product categories:**
orderby="name" ( Accepts term fields ('name', 'slug', 'term_group', 'term_id', 'id', 'description') )
* **Order:**
order="ASC" (Accepts 'ASC' (ascending) or 'DESC' (descending). Default 'ASC' )
* **hide_empty:**
hide_empty="1" (Accepts 1|true or 0|false. Default 1|true. )
* **ids:**
ids="1" (Display Specific Category. values are Comma separated Category Id. By Default is all.)
* **height:**
height="300" (Set the height for Category.)

**Product Categories in Slider**

<code>[wpos_product_categories_slider]</code>

* **Design:**
design="design-2" (Design Number to Display your Product Category. Values are design-1 or design-2. By Default value is design-1.)
* **number:**
number="5" ( ie Display 5 product categories at time. By defoult value is all )
* **Order by product categories:**
orderby="name" ( Accepts term fields ('name', 'slug', 'term_group', 'term_id', 'id', 'description') )
* **Order:**
order="ASC" (Accepts 'ASC' (ascending) or 'DESC' (descending). Default 'ASC' )
* **hide_empty:**
hide_empty="1" (Accepts 1|true or 0|false. Default 1|true. )
* **ids:**
ids="1" (Display Specific Category. values are Comma separated Category Id. By Default is all.)
* **height:**
height="300" (Set the height for Category.)
* **Display number of product categories at time:**
slidestoshow="3" (Display no of product categories in a slider )
* **Number of products categories slides at a time:**
slidestoscroll="1" (Controls number of product categories rotate at a time)
* **Pagination and arrows:**
dots="false" arrows="false" (Hide/Show pagination and arrows. By defoult value is "true". Values are true OR false)
* **Autoplay and Autoplay Speed:**
autoplay="true" autoplay_interval="1000"
* **Slide Speed:**
speed="3000" (Control the speed of the slider)
* **loop:**
loop="3000" ( By defoult value is "true". Values are true OR false)


= Stunning Features: =

* Product Categoriews in grid
* Product Categoriews in grid Slider
* 100% Mobile & Tablet Responsive
* Awesome Touch-Swipe Enabled
* Work in any WordPress Theme
* Created with Slick Slider
* Lightweight, Fast & Powerful
* Set Number of Columns you want to show
* Slider AutoPlay on/off
* Navigation show/hide options
* Pagination show/hide options

= PRO Features Includes =
> <strong>Premium Version</strong><br>
>
> * 10 stunning and cool designs for Woocommerce Categories.
> * Product Categories in Grid view
> * Product Categories in Slider view
> * Created with Slick Slider
> * Awesome Touch-Swipe Enabled
> * Work in any WordPress Theme
> * Wp Templating Feature
> * Visual Composer / WPBackery Support
> * Display category title and description.
> * Display product count.
> * Display specific categories.
> * Exclude specific categories.
> * Category order and orderby sorting parameter.
> * Lightweight, Fast & Powerful
> * Set Number of Columns you want to show
> * Slider Auto Play on/off
> * Navigation show/hide options
> * Pagination show/hide options
> * 100% Mobile & Tablet Responsive
>
> Check [Demo and Features](https://demo.wponlinesupport.com/prodemo/product-categories-designs-for-woo-pro/) for additional information.
>


== Installation ==
1. Upload the 'product-categories-designs-for-woocommerce' folder to the '/wp-content/plugins/' directory.
2. Activate the "product-categories-designs-for-woocommerce" list plugin through the 'Plugins' menu in WordPress.

= This plugin contain 2 shortcode: =
1) Display WooCommerce **product categories in grid** view
<code>[wpos_product_categories]</code>

2) Display WooCommerce **product categories in slider / carousel view**
<code>[wpos_product_categories_slider]</code>

== Screenshots ==

1. Design 1
2. Design 2
3. Shortcodes and how to display


== Changelog ==

= 1.2.1 (01-02-2020) =
* [*] Updated features list.
* [*] Tested with latest version of WooCommerce.

= 1.2 =
* [*] Fixed : get_woocommerce_term_meta deprecated error solved.
* [*] Fixed : Slider shortcode [wpos_product_categories_slider] order and orderby parameter solve.
* [*] Fixed : Fixed some minor html stucture.

= 1.1.4 =
* [*] Tested with WooCommerce version 3.7.0

= 1.1.3 =
* [*] Tested with WooCommerce version 3.5.1

= 1.1.2 =
* [*] Tested with WooCommerce version 3.3

= 1.1.1 =
* [+] Added "How it work" tab under Products
* [+] Added "height" shortcode parameter
* [+] Added new function pcdfwoo_column();
* Fixed grid bug
* Fixed slider bug
* Imporived designs

= 1.1 =
* Fixed some design bug

= 1.0 =
* Initial release.
