import { inject, injectable } from "inversify";
import dropifyConfig from '../../../Config/dropify';
import MainService from "./main.service";
import "bootstrap-switch-button/dist/bootstrap-switch-button.min";
import "bootstrap-switch-button/css/bootstrap-switch-button.css";
@injectable()
export default class MainComponent {
    constructor(
        @inject(MainService) mainService: MainService
    ) {
       $('.chkSwitch').switchbutton();
       console.warn(55)

    }
}