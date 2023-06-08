import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/app.css",
                "resources/lib/owlcarousel/assets/owl.carousel.min.css",
                "resources/lib/animate/animate.min.css",
                "resources/lib/easing/easing.min.js",
                "resources/lib/waypoints/waypoints.min.js",
                "resources/lib/counterup/counterup.min.js",
                "resources/lib/owlcarousel/owl.carousel.min.js",
                "resources/js/app.js",
                "resources/js/requires/main.js",
                "resources/vendors/js/vendor.bundle.base.js",
                "resources/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js",
                "resources/vendors/progressbar.js/progressbar.min.js",
                "resources/js/requires/off-canvas.js",
                "resources/js/requires/hoverable-collapse.js",
                "resources/js/requires/template.js",
                "resources/js/requires/settings.js",
                "resources/js/requires/todolist.js",
                "resources/js/requires/dashboard.js",
                "resources/js/custom/users.js",
                "resources/js/custom/deleteuser.js",
                "resources/js/custom/advantage/index.js",
                "resources/js/custom/auditory/app.js",
                "resources/js/custom/blogs/create.js",
                "resources/js/custom/gallery/app.js",
                "resources/js/custom/rol/app.js",
                "resources/js/custom/web/app.js",
                "resources/css/vertical-layout-light/style.css",
                "resources/vendors/css/vendor.bundle.base.css",
                "resources/vendors/simple-line-icons/css/simple-line-icons.css",
                "resources/vendors/typicons/typicons.css",
                "resources/vendors/ti-icons/css/themify-icons.css",
                "resources/vendors/mdi/css/materialdesignicons.min.css",
                "resources/vendors/feather/feather.css",
                "resources/css/spiner.css",
                "resources/css/loader.css",
                "resources/css/403.css",
                "resources/js/app.js",
                "resources/js/newsapapi.js",
                "resources/js/sapApi/ventasDia.js",
                "resources/js/sapApi/ventasDiaAnterior.js",
                "resources/js/sapApi/ventasDiaAnterior.js",
                "resources/js/sapApi/ventasSemana.js",
                "resources/css/card.css",
                "resources/js/sapApi/ventas.js",
                "resources/js/sapApi/ventasSemanaAnterior.js",
                "resources/js/custom/budget/imports.js",
                "resources/js/custom/budget/edit.js",
                "resources/js/custom/calendar/app.js",
                "resources/js/ckeditor/build/ckeditor.js",
                "resources/js/custom/successcase/index.js",
                "resources/js/custom/pages/edit.js",
                "resources/js/home/app.js",
                "resources/js/sapApi/employes/list.js",
            ],
            refresh: true,
        }),
    ],
});
