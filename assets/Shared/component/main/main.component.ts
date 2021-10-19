import { inject, injectable } from "inversify";
import dropifyConfig from '../../../Config/dropify';
import switchButtonConfig from '../../../Config/switchButton';
import MainService from "./main.service";


@injectable()
export default class MainComponent {
    constructor(
        @inject(MainService) mainService: MainService
    ) {
       $('.dropify-fr').dropify(dropifyConfig);
       $('.chkSwitch').switchbutton(switchButtonConfig);
    }
}