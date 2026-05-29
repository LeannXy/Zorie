import ApexCharts from 'apexcharts'
import Alpine from 'alpinejs'
import { createIcons, icons } from 'lucide'

import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

window.Alpine = Alpine
window.ApexCharts = ApexCharts

Alpine.start()

document.addEventListener(
    "DOMContentLoaded",
    () => {

        createIcons({ icons });

        let categoryElement =
        document.querySelector(
            "#categories"
        );

        if(
            categoryElement &&
            !categoryElement.tomselect
        ){

            window.categorySelect =
            new TomSelect(
                categoryElement,
                {

                    plugins:[
                        'remove_button'
                    ],

                    placeholder:
                    'Search categories...',

                    create:false

                }
            );

        }

    }
);