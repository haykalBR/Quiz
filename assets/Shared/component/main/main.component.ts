import { inject, injectable } from "inversify";
import dropifyConfig from '../../../Config/dropify';
import MainService from "./main.service";
@injectable()
export default class MainComponent {
    constructor(
        @inject(MainService) mainService: MainService
    ) {
    }
}