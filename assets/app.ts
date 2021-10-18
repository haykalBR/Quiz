import './styles/app.css';
import container from './Container';
import MainComponent from './Shared/component/main/main.component';
container.resolve<MainComponent>(MainComponent);
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";
// init,configure dropzone
Dropzone.autoDiscover = false;
console.warn(55)
var dropzone_default = new Dropzone(".dropzone", {
    url: '#' ,
    maxFiles: 1,
    dictMaxFilesExceeded: 'Only 1 Image can be uploaded',
    acceptedFiles: 'image/*',
    maxFilesize: 3,  // in Mb
    addRemoveLinks: true,

});





