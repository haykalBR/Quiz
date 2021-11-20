import { inject, injectable } from "inversify";
import dropifyConfig from '../../../Config/dropify';
import switchButtonConfig from '../../../Config/switchButton';
import MainService from "./main.service";
import 'bootstrap-switch-button';
import 'select2';

@injectable()
export default class MainComponent {
    constructor(
        @inject(MainService) mainService: MainService
    ) {
        console.warn(44)
       $('.dropify-fr').dropify(dropifyConfig);
        $('.select2').select2({
         width: 'resolve'
        });
     //  $('.chkSwitch').switchbutton(switchButtonConfig);
    }
}