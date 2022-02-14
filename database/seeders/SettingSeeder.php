<?php

namespace Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=SettingSeeder
     *
     * @return void
     */
    public function run()
    {
        $this->addSetting(['key' => 'checklist_item_limit'], [
            'name' => 'Checklist limit',
            'description' => 'For checklist item limit',
            'value' => '4',
            'field' => '{"name":"value","label":"Value","type":"number"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'relation_checklist_item_limit'], [
            'name' => 'Relation Checklist limit',
            'description' => 'For relation checklist item limit',
            'value' => '1',
            'field' => '{"name":"value","label":"Value","type":"number"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'show_powered_by'], [
            'name' => 'Showed Powered By',
            'description' => 'Whether to show the powered by Backpack on the bottom right corner or not.',
            'value' => '1',
            'field' => '{"name":"value","label":"Value","type":"checkbox"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'skin'], [
            'name' => 'Skin',
            'description' => 'Backpack admin panel skin settings.',
            'value' => 'app-header bg-dark navbar,app aside-menu-fixed sidebar-lg-show,sidebar bg-white sidebar-pills,app-footer d-none',
            'field' => '{"name":"value","label":"Value","type":"select2_from_array","options":{"app-header bg-light border-0 navbar,app aside-menu-fixed sidebar-lg-show,sidebar sidebar-pills bg-light,app-footer":"Backstrap","app-header navbar,app aside-menu-fixed sidebar-lg-show,sidebar,app-footer d-none":"CoreUI","app-header bg-dark navbar,app aside-menu-fixed sidebar-lg-show,sidebar bg-white sidebar-pills,app-footer d-none":"Github","app-header navbar navbar-color bg-primary border-0,app aside-menu-fixed sidebar-lg-show,sidebar,app-footer d-none":"Blue Top Menu","app-header navbar navbar-light bg-warning,app aside-menu-fixed sidebar-lg-show,sidebar,app-footer d-none":"Construction / Warning","app-header navbar navbar-color bg-error border-0,app aside-menu-fixed sidebar-lg-show,sidebar,app-footer d-none":"Red Top Menu","app-header navbar navbar-color bg-error border-0,app aside-menu-fixed sidebar-lg-show,sidebar sidebar-pills bg-light,app-footer d-none":"Pink Top Menu","app-header navbar navbar-color bg-green border-0,app aside-menu-fixed sidebar-lg-show,sidebar sidebar-pills bg-white,app-footer d-none":"Green Top Menu"},"allows_null":false,"default":"app-header bg-light border-0 navbar,app aside-menu-fixed sidebar-lg-show,sidebar sidebar-pills bg-light,app-footer"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'project_name'], [
            'name' => 'Project Name',
            'description' => 'Naming the system.',
            'value' => 'Contest Management System',
            'field' => '{"name":"value","label":"Value","type":"text"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'project_logo'], [
            'name' => 'Project Logo',
            'description' => 'Logo or Text for project.',
            'value' => '<img alt="" src="http://127.0.0.1:8000/uploads/1%2BMaterial%2BDesign%2BLogo.gif" style="height:34px; width:45px; margin-right: 10px;" /><strong>Contest</strong>',
            'field' => '{"name":"value","label":"Value","type":"wysiwyg","options":{"enterMode":"CKEDITOR.ENTER_BR","shiftEnterMode":"CKEDITOR.ENTER_P"}}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'browser_tab_logo'], [
            'name' => 'Browser Tab Logo',
            'description' => 'Logo for browser tab.',
            'value' => 'uploads/NicePng_guarantee-png_9005246.png',
            'field' => '{"name":"value","label":"Value","type":"wysiwyg","options":{"enterMode":"CKEDITOR.ENTER_BR","shiftEnterMode":"CKEDITOR.ENTER_P"}}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'slider_frontend'], [
            'name' => 'Slider',
            'description' => 'Frontend slider',
            'value' => '[{"content":"\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-right\">\n                                    <div class=\"big-tagline\">\n                                        <h2><strong>SmartEDU <\/strong> education College<\/h2>\n                                        <p class=\"lead\">With Landigoo responsive landing page template, you can promote your all hosting, domain and email services. <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>","image":"uploads\/9edf59e62f91d9f274e289f2585e8c12.jpg"},{"content":"                <div class=\"first-section\">\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-left\">\n                                    <div class=\"big-tagline\">\n                                        <h2 data-animation=\"animated zoomInRight\">SmartEDU <strong>education school<\/strong><\/h2>\n                                        <p class=\"lead\" data-animation=\"animated fadeInLeft\">With Landigoo responsive landing page template, you can promote your all hosting, domain and email services. <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>\n                <\/div>","image":"uploads\/ccff1b1f3bea830498d236425debb7ca.jpg"},{"content":"\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-center\">\n                                    <div class=\"big-tagline\">\n                                        <h2 data-animation=\"animated zoomInRight\"><strong>VPS Servers<\/strong> Company<\/h2>\n                                        <p class=\"lead\" data-animation=\"animated fadeInLeft\">\n                                            1 IP included with each server\n                                            Your Choice of any OS (CentOS, Windows, Debian, Fedora)\n                                            FREE Reboots\n                                        <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>","image":"uploads\/cf68fc321940a0f097b85328a5fc619c.jpg"}]',
            'field' => '{"name":"value","label":"Value","type":"repeatable","fields":[{"name":"content","type":"summernote","label":"Content"},{"name":"image","type":"custom.image","label":"Image","app_url":"' . env('APP_URL', '') . '"}]}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'slider_frontend_kh'], [
            'name' => 'Slider Khmer',
            'description' => 'Frontend slider khmer',
            'value' => '[{"content":"\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-right\">\n                                    <div class=\"big-tagline\">\n                                        <h2><strong>SmartEDU <\/strong> education College<\/h2>\n                                        <p class=\"lead\">With Landigoo responsive landing page template, you can promote your all hosting, domain and email services. <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>","image":"uploads\/9edf59e62f91d9f274e289f2585e8c12.jpg"},{"content":"                <div class=\"first-section\">\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-left\">\n                                    <div class=\"big-tagline\">\n                                        <h2 data-animation=\"animated zoomInRight\">SmartEDU <strong>education school<\/strong><\/h2>\n                                        <p class=\"lead\" data-animation=\"animated fadeInLeft\">With Landigoo responsive landing page template, you can promote your all hosting, domain and email services. <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>\n                <\/div>","image":"uploads\/ccff1b1f3bea830498d236425debb7ca.jpg"},{"content":"\n                    <div class=\"dtab\">\n                        <div class=\"container\">\n                            <div class=\"row\">\n                                <div class=\"col-md-12 col-sm-12 text-center\">\n                                    <div class=\"big-tagline\">\n                                        <h2 data-animation=\"animated zoomInRight\"><strong>VPS Servers<\/strong> Company<\/h2>\n                                        <p class=\"lead\" data-animation=\"animated fadeInLeft\">\n                                            1 IP included with each server\n                                            Your Choice of any OS (CentOS, Windows, Debian, Fedora)\n                                            FREE Reboots\n                                        <\/p>\n                                    <\/div>\n                                <\/div>\n                            <\/div>\n                        <\/div>\n                    <\/div>","image":"uploads\/cf68fc321940a0f097b85328a5fc619c.jpg"}]',
            'field' => '{"name":"value","label":"Value","type":"repeatable","fields":[{"name":"content","type":"summernote","label":"Content"},{"name":"image","type":"custom.image","label":"Image","app_url":"' . env('APP_URL', '') . '"}]}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'history_timeline'], [
            'name' => 'History Timeline',
            'description' => 'History Timeline',
            'value' => '[{"content":"\n                                <h2>2018<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/9f42571c906065995f0f6b34a433b63a.jpg"},{"content":"\n                                <h2>2015<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>","image":"uploads\/da20a369a9c5b0f11996c0724b32d78a.jpg"},{"content":"\n                                <h2>2014<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>","image":"uploads\/95cb7ef2981f44b35e5947c63c2cea3a.jpg"},{"content":" \n                                <h2>2012<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/47afc889c5e8ece0737d3ac64c1bcc59.jpg"},{"content":"\n                                <h2>2010<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/9f42571c906065995f0f6b34a433b63a.jpg"}]',
            'field' => '{"name":"value","label":"Value","type":"repeatable","fields":[{"name":"content","type":"summernote","label":"Content"},{"name":"image","type":"custom.image","label":"Image","app_url":"' . env('APP_URL', '') . '"}]}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'history_timeline_kh'], [
            'name' => 'History Timeline Khmer',
            'description' => 'History Timeline Khmer',
            'value' => '[{"content":"\n                                <h2>2018<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/9f42571c906065995f0f6b34a433b63a.jpg"},{"content":"\n                                <h2>2015<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>","image":"uploads\/da20a369a9c5b0f11996c0724b32d78a.jpg"},{"content":"\n                                <h2>2014<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>","image":"uploads\/95cb7ef2981f44b35e5947c63c2cea3a.jpg"},{"content":" \n                                <h2>2012<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/47afc889c5e8ece0737d3ac64c1bcc59.jpg"},{"content":"\n                                <h2>2010<\/h2>\n                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem\n                                    ipsum dolor sit amet, consectetur adipiscing elit.<\/p>\n","image":"uploads\/9f42571c906065995f0f6b34a433b63a.jpg"}]',
            'field' => '{"name":"value","label":"Value","type":"repeatable","fields":[{"name":"content","type":"summernote","label":"Content"},{"name":"image","type":"custom.image","label":"Image","app_url":"' . env('APP_URL', '') . '"}]}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'contact_details'], [
            'name' => 'Contact Details',
            'description' => 'Contact Details',
            'value' => '<ul class="footer-links">
                <li><a href="mailto:#">cambmathsociety@gmail.com</a></li>
                <li><a href="#">www.cambmathsociety.org</a></li>
                <li>#National Institute of Education, New Generation Pedagogical Research Center, Building I, Preach Norodom Boulevard, Phnom Penh.</li>
                <li>(855) 11 697 038</li>
            </ul>',
            'field' => '{"name":"value","label":"Value","type":"summernote"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'contact_details_kh'], [
            'name' => 'Contact Details Khmer',
            'description' => 'Contact Details Khmer',
            'value' => '<ul class="footer-links"><li><a href="mailto:#">cambmathsociety@gmail.com</a></li><li><a href="http://127.0.0.1:8000/admin/setting/20/edit#">www.cambmathsociety.org</a></li><li>#វិទ្យាស្ថានជាតិអប់រំមជ្ឈមណ្ឌលស្រាវជ្រាវ, គរុកោសល្យជំនាន់ថ្មីអគារ ១, មហាវិថីព្រះនរោត្តម, រាជធានីភ្នំពេញ<br></li><li>(៨៥៥) ១១ ៦៩៧ ០៣៨</li></ul>',
            'field' => '{"name":"value","label":"Value","type":"summernote"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'about_us_content'], [
            'name' => 'About Us',
            'description' => 'About Us',
            'value' => '<p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>',
            'field' => '{"name":"value","label":"Value","type":"summernote"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'about_us_content_kh'], [
            'name' => 'About Us Khmer',
            'description' => 'About Us Khmer',
            'value' => '<p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>',
            'field' => '{"name":"value","label":"Value","type":"summernote"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'social_links'], [
            'name' => 'Social Link',
            'description' => 'Social Link',
            'value' => '[{"icon":"fab fa-facebook-f","link":"https://www.facebook.com/"},{"icon":"fab fa-github","link":"https://github.com/"},{"icon":"fab fa-twitter","link":"https://twitter.com/?lang=en"}]',
            'field' => '{"name":"value","label":"Value","type":"repeatable","fields":[{"name":"icon","type":"icon_picker","label":"Icon","iconset":"fontawesome"},{"name":"link","type":"text","label":"Link"}]}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'contact_us_email'], [
            'name' => 'Email',
            'description' => 'For contact us send mail',
            'value' => 'lovsokheang@gmail.com',
            'field' => '{"name":"value","label":"Value","type":"email"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'contact_us_latlng'], [
            'name' => 'Latitude, Longitude',
            'description' => 'For contact us map position',
            'value' => '11.5583623,104.9252308',
            'field' => '{"name":"value","label":"Value","type":"text"}',
            'active' => 1
        ]);
        $this->addSetting(['key' => 'contact_map_iframe'], [
            'name' => 'Map iframe',
            'description' => 'Map iframe for contact',
            'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15634.573473760402!2d104.91229987281496!3d11.577403807794164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31095144cbdbf311%3A0x2588e1ac1787eb64!2sWat%20Phnom!5e0!3m2!1sen!2skh!4v1634372816224!5m2!1sen!2skh" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'field' => '{"name":"value","label":"Value","type":"summernote"}',
            'active' => 1
        ]);
    }

    public function addSetting(array $keys, array $data)
    {
        Setting::firstOrCreate($keys, $data);
    }
}
