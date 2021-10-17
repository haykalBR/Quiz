import { inject, injectable } from "inversify";
import dropifyConfig from '../../../Config/dropify';
import 'dropify/dist/css/dropify.css';
import MainService from "./main.service";
@injectable()
export default class MainComponent {
    constructor(
        @inject(MainService) mainService: MainService
    ) {
        // @ts-ignore
      //  $('.dropify-fr').dropify(dropifyConfig);
    }
}