var uploadHandler = function(){
  /**
  * Set the currnet object to global window object
  * so we can access it from anoynmous function
  */
  var UploadHandler = this;
  /**
  * object property for holding file uploaded in current selection or drag and drop
  * @var array
  */
  this.files = [];
  /**
  * object property for holding file which are ignored for uploading to the server
  * due validation failure
  * @var array
  */
  this.ignoredFiles = [];
  /**
  * object property for holding file which completed uploading to the server
  * @var array
  */
  this.fileDone = [];
  /**
  * object property for holding fileList 
  * hold all the selected files
  * @var array
  */
  this.fileList = [];  
  /**
  * object property for holding validation rule need to be converted based on identification
  * @var array
  */
  this.ruleNeedConversion = ['mime'];      
  /**
  * object property for holding validation rule convertion identification
  * @var string
  */
  this.conversionIdentification = ',';      
  /**
  * object property for public access token
  * @var string
  */
  this.publicAccessToken = false;    
  /**
  * object property for access token
  * @var string
  */
  this.accessToken = false;    
  /**
  * object property for user
  * @var string
  */
  this.userId = false;    
  /**
  * object property for holding request file name send to the server
  * @var string
  */
  this.requestFileName = 'image';  
  /**
  * object property for holding various Identifiers used in the dom
  * @var string
  */
  this.identifiers = {
    parentDiv      : 'stat-',
    statP          : 'pstat-',
    previewImage   : 'preview-image-',
    progressDiv    : 'progress-',
    removeIcon     : 'iconstat-'
  };
  /**
  * object property for holding various classes used in the dom
  * @var string
  */
  this.classes = {
    parentDiv          : 'file-stat',
    parentFileDiv      : 'file-stat file-doc',
    fileLogoDiv        : 'file-doc-logo',
    progressContainer  : 'progress',
    progressDiv        : 'progress-bar progress-bar-success progress-bar-striped active',
    removeIcon         : 'fa fa-times',
    fileActive         : 'file-active',
    fileError          : 'file-error',
    fileSuccess        : 'file-success',
    hide               : 'hide',
    success            : 'success',
    progressBarDanger  : 'progress-bar-danger',
    progressBarSuccess : 'progress-bar-success'    
  };            
  /**
  * Intialize the upload handler
  * such set the dom object and various upload events listners
  * @param object options
  * @return void
  * @throws Exception
  */  
  this.initate = function(options) {
      /**
      * Since we use HTML5 object for uploading
      * if browser not going to support we are just going to igore it
      */ 
      if(this.isBrowserSupportedHtmlFive()){
        /**
         * Define default options
         */
        var opt = {
            file        : 'image',
            drag        : 'drag',
            progress    : 'progress',
            url         : false,
            button      : false,
            previewer   : false ,
            deleteIcon  : false,
            beforeUpload : false,
            afterUpload : false ,
            isImageFileType     : true ,
            validImage  : {
              fileSize          : 1048576,
              mime              : ["jpeg", "png"],
              fileLimit         : 50,
              minimumResolution : "400x300",
            },
            validFile  : {
                fileSize          : 1048576,
                mime              : ["xlsx","xls","csv"],
                fileLimit         : 50,
              },            
            preview     : {
              width  : 180,
              height : 180
            },
            locale      : {
              stat  : {
                waiting    : 'waiting..',
                processing : 'processing..',
                uploading  : 'uploading(:pc)..',
                done       : 'Done',
                failed     : 'Failed'
              },
              error : {
                minimumResolution : 'Image minimum resolution should be atleast :resolution',
                mime              : 'File should be in :mime',
                fileSize          : 'Image size should be less than :maxSize MB',
                invalid           : 'Image minimum resolution should be atleast 400x300',                
                otherFileSize     : 'File size should be less than :maxSize MB',
              },
              documenterror: {
            	  invalid       : 'Document selected is Invalid',  
              }
            },
        };

        /**
         * Merge the default option with custom options
         *
         */
        this.options  = (typeof options == 'object') ? $.extend({}, opt, options) : opt;

        /**
         * get required dom object based on the options provided or using default options
         */
        this.file     = document.getElementById(this.options.file);
        this.drag     = document.getElementById(this.options.drag);
        this.progress = document.getElementById(this.options.progress);
        this.button   = this.options.button ? document.getElementById(this.options.button) : false;
        this.previewer  = this.options.previewer ? document.getElementById(this.options.previewer) : false;
        this.deleteIcon = this.options.deleteIcon ? document.getElementById(this.options.deleteIcon) : false;


        /**
         * set header with access token
         * validate required options is set
         * update the validation information to options based on the file data attributes
         */
         this.setHeaders().validateOptions().updateValidationInformation();

        /**
         * define the listner for various upload events
         * includes file select and drag and drop
         */
        this.file.addEventListener("change", this.fileSelectHandler, false);

        if(this.drag){
          this.drag.addEventListener("dragover", this.fileDragHover, false);
          this.drag.addEventListener("dragleave", this.fileDragHover, false);
          this.drag.addEventListener("drop", this.fileSelectHandler, false);
        }

        if(this.button){
          this.button.addEventListener("click", function(e) {
              e.preventDefault();
              UploadHandler.uploadPrepare();
          }, false);
        }
      }
  };
  /**
  * Set Headers from meta tag
  * @return object
  */    
  this.setHeaders = function() {
      for(var i = 0, meta; meta = document.getElementsByTagName('meta')[i]; i++){
        if(meta.name == 'public-access-token'){
          this.publicAccessToken = meta.content;
        }

        if(meta.name == 'user-id'){
          this.userId = meta.content;
        }

        if(meta.name == 'access-token'){
          this.accessToken = meta.content;
        }

        if(meta.name == 'csrf-token'){
          this.csrfToken = meta.content;
        }
      }

    return this;
  };
  /**
  * Get XMLHttpRequest with appropriate headers
  * set action method and 
  * @return object
  */    
  this.getXMLHttpRequest = function() {
    var xhr = new XMLHttpRequest();

    xhr.open("POST", this.options.url);
    xhr.setRequestHeader('X-CSRF-TOKEN' , this.csrfToken);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('X-ADMIN-WEB-SERVICE', true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-ADMIN-PUBLIC-ACCESS-TOKEN', this.publicAccessToken);
    xhr.setRequestHeader('X-ADMIN-USER-ID', this.userId);
    xhr.setRequestHeader('X-ADMIN-ACCESS-TOKEN', this.accessToken);

    return xhr;
  };       
  /**
  * valid the config options
  * @return object
  * @throws Exception
  */  
  this.validateOptions = function() {
   /**
     * check file element exist
     * else throw the exception
     */
    if(!this.file){
      throw "File element not exist";
    }

    /**
     * check file element exist
     * else throw the exception
     */
    if(!this.progress){
      throw "Preview element not exist";
    }

    /**
     * check action is set in data attribute 
     * else throw the exception
     */
    if(!this.options.url){
      throw "Request URL should be set in options";
    }

    return this;    
  };    
  /**
  * update the validation information
  * based on the file data attributes
  * @return void
  */  
  this.updateValidationInformation = function() {
    for(var rule in this.options.validImage) {
      if(this.file.dataset.hasOwnProperty(rule)){
        this.options.validImage[rule] = (this.ruleNeedConversion.indexOf(rule) == -1) ? this.file.dataset[rule] : this.file.dataset[rule].split(this.conversionIdentification);
      }
    };
  };  
  /**
  * check browser support HTML5
  * @return boolean
  */  
  this.isBrowserSupportedHtmlFive = function() {
      return (window.Image && window.File && window.FileList && window.FileReader && (new XMLHttpRequest).upload);
  };
  /**
  * File select and drop event listener
  * @event change file
  * @event drop file
  * @return void
  */    
  this.fileSelectHandler = function(e) { 
      e.stopPropagation();
      e.preventDefault();
      var fileList = e.target.files || e.dataTransfer.files;

      if(fileList.length > 0){
        UploadHandler.processFile(fileList);
      }
  };
  /**
  * Clean the file dom when the upload completed
  * @return void
  */    
  this.cleanFileElement = function() {
      try {
       this.file.value = null;
      } catch (ex) {}

     if(this.file.value){
       this.file.parentNode.replaceChild(this.file.cloneNode(true), this.file);
     } 
  };  
  /**
   * Get File limit based on the file selected
   * if file type is not image validFile fileLimit property is used
   * else if file type is image validIMage fileLimit property is used
   * @return int
   */    
   this.getFileLimit = function() {
       return (this.options.isImageFileType) ? this.options.validImage.fileLimit : this.options.validFile.fileLimit
   };    
  /**
  * File dragover and dragleave event listener
  * @event dragover
  * @event dragleave
  * @return void
  */    
  this.fileDragHover = function(e) {
      e.stopPropagation();
      e.preventDefault();
      e.target.className = (e.type == "dragover" ? "hover" : "");
  };  
  /**
  * File select and drop event listener
  * @event object fileList
  * @event drop file
  * @return void
  */      
  this.processFile = function(fileList) {
    /**
     * Check whether beforeUpload function is available. If yes, then execute it.
     */
    if(this.options.beforeUpload && typeof this.options.beforeUpload == 'function'){
      this.options.beforeUpload.call();
      }
      /**
       * make sure every file holding array is empty
       * and progress is empty
       */    
      UploadHandler.files = [];
      UploadHandler.fileDone = [];
      UploadHandler.ignoredFiles = [];
      UploadHandler.progress.innerHTML = '';

      /**
       * get the files uploaded
       */
      UploadHandler.fileList = fileList;

      /**
       * Valid file selected not exceed the allowed 
       * @rule fileLimit 
       * 
       */ 
      if(typeof UploadHandler.fileList != 'object' || UploadHandler.fileList.length > UploadHandler.getFileLimit()){
        return false;
      }

      /**
       * Iterator through each file
       */   
      for (var i = 0, f; f = UploadHandler.fileList[i]; i++) {
          UploadHandler.files[i] = f;
          UploadHandler.prepareFile(f, i);
      }

      /**
       * If are file selected so the progress section
       */      
      if (UploadHandler.files.length > 0 || UploadHandler.ignoredFiles.length > 0) {
          UploadHandler.progress.classList.remove(UploadHandler.classes.hide);
      }

      UploadHandler.afterProcessFile();
  };
  /**
  * based user input proceed to image upload
  * @return void
  */    
  this.afterProcessFile = function() {
    if(this.files.length > 0){
      /**
       * here setInterval is used so uploadProgress is waited till 
       * uploaded image are previewed
       */
      var processed = setInterval(function(){
        if(UploadHandler.fileList.length == (UploadHandler.ignoredFiles.length + UploadHandler.files.length)){
          clearInterval(processed);

          if(UploadHandler.button){
            UploadHandler.button.disabled = false;
          } else {
            UploadHandler.uploadPrepare();
          }
        }
      },200);
    }
  }; 
  /**
  * empty progress list
  * @return object
  */    
  this.emptyProgressList = function() {
    if(typeof this.progress == 'object'){
      while(this.progress.hasChildNodes()){
        this.progress.removeChild(this.progress.lastChild);
      }

      this.progress.classList.add(this.classes.hide);      
    }

    if(this.previewer){
      this.previewer.classList.remove(this.classes.hide);
    }    
    if(this.deleteIcon){
        this.deleteIcon.classList.remove(this.classes.hide);
    }

    return this;
  };
  /**
   * remove progress list by index
   * 
   * @param index
   * @return object
   */    
   this.removeProgressListByIndex = function(index) {
     if(typeof this.progress == 'object'){
       var progressElement = document.getElementById(this.identifiers.parentDiv+index) 

       if(typeof progressElement == 'object' && progressElement != null){
           progressElement.parentNode.removeChild(progressElement);
       }
     }

     return this;
   };  
  /**
  * Load selected image file with fileReader
  * @param object file
  * @param int index
  * @return void
  */    
  this.loadImage = function(file,index) {
    var reader = new FileReader();

    reader.onload = function(e){
      file.previewSrc = e.target.result;

      var validateErrors = UploadHandler.validateImageFile(file);
      
      if (validateErrors.length > 0) {
          UploadHandler.ignoredFiles.push(index);
          UploadHandler.files.splice(index, 1);
      } 

      UploadHandler.previewFile(file,index,e.target.result,validateErrors);
    }  

    reader.readAsDataURL(file);
  };    
  /**
  * Preview the file with html
  * if file has failed with the validation instead showing image
  * exception messgae is shown
  * 
  * @param object file
  * @param int index
  * @param string fileSrc
  * @param object validationErrors
  * @return void
  */      
  this.previewFile = function(file,index,fileSrc,validationErrors) {
    if(this.previewer){
      this.previewer.classList.add(this.classes.hide);
    }
    if(this.deleteIcon){
        this.deleteIcon.classList.add(this.classes.hide);
    }

    var parentDiv = this.createParentDiv(parentDiv,index);

    if(validationErrors.length > 0){
      this.createElementWithError(parentDiv,index,validationErrors);
      return;
    }   
    
    this.createStatElememt(parentDiv,index);

    if(this.isImage(file)){
        this.createImageElement(parentDiv,index,fileSrc,file);
    } else {
      this.createFileElement(parentDiv);
    }

    this.createProgresser(parentDiv,index);

    this.createRemoveIcon(parentDiv,index);

    file.index = index;
  }; 
  /**
  * Create html for parent div
  * 
  * @param object parentDiv
  * @param int index  
  * @return object
  */      
  this.createParentDiv = function(parentDiv,index) {
    var parentDiv = this.progress.appendChild(document.createElement("div"));

    var clz = document.createAttribute("class");
    clz.value = this.options.isImageFileType ? this.classes.parentDiv : this.classes.parentFileDiv;
    parentDiv.setAttributeNode(clz);

    var uniqueClz = document.createAttribute("class");
    uniqueClz.value = this.identifiers.parentDiv + index;
    parentDiv.setAttributeNode(uniqueClz);

    var id = document.createAttribute("id");
    id.value = this.identifiers.parentDiv + index;
    parentDiv.setAttributeNode(id);

    return parentDiv;    
  };
  /**
  * Create html for displaying various file status
  * 
  * @param object parentDiv
  * @param int index  
  * @return void
  */      
  this.createStatElememt = function(parentDiv,index) {
    var sp = parentDiv.appendChild(document.createElement("p"));
    sp.appendChild(document.createTextNode(this.options.locale.stat.waiting));

    var uniqueClz = document.createAttribute("class");
    uniqueClz.value = this.identifiers.statP + index;
    sp.setAttributeNode(uniqueClz);

    var id = document.createAttribute("id");
    id.value = this.identifiers.statP + index;
    sp.setAttributeNode(id);  
  };   
  /**
  * Create html for displaying various file status
  * 
  * @param object parentDiv
  * @param int index  
  * @param object validateErrors
  * @return void
  */      
  this.createElementWithError = function(parentDiv,index,validateErrors) {
    for(var iter = 0, error; error = validateErrors[iter]; iter++){
      if(this.options.locale.error.hasOwnProperty(error)){
        var messgae = false;

        switch(error){
          case 'minimumResolution':
            messgae = this.options.locale.error[error].replace(/:resolution/g, this.options.validImage.minimumResolution);
          break;
          case 'mime':
            messgae = this.options.locale.error[error].replace(/:mime/g, this.options.validImage.mime.join(','));
          break;
          case 'fileSize':
            messgae = this.options.locale.error[error].replace(/:maxSize/g, this.options.validImage.fileSize/(1024*1024));
          break;
          case 'otherFileSize':
        	  messgae = this.options.locale.error[error].replace(/:maxSize/g, this.options.validFile.fileSize/(1024*1024));
        	  break;
          default:
            messgae = false;
          break;
        }

        if(messgae){
          var sp = parentDiv.appendChild(document.createElement("p"));
          sp.appendChild(document.createTextNode(messgae));
        }
      }
    }

    parentDiv.classList.add("file-error");  
  };        
  /**
  * Create html for parent div
  * 
  * @param object parentDiv
  * @param int index
  * @param string imageSrc
  * @param object file
  * @return void
  */      
  this.createImageElement = function(parentDiv,index,imageSrc,file) {
    var image = parentDiv.appendChild(document.createElement("img"));

    var src = document.createAttribute("src");
    src.value = imageSrc;
    image.setAttributeNode(src);

    var title = document.createAttribute("title");
    title.value = file.name;
    image.setAttributeNode(title);

    var width = document.createAttribute("width");
    width.value = this.options.preview.width;
    image.setAttributeNode(width);

    var height = document.createAttribute("height");
    height.value = this.options.preview.height;
    image.setAttributeNode(height);

    var id = document.createAttribute("id");
    id.value = this.identifiers.previewImage + index;
    image.setAttributeNode(height);        
  };  
  /**
   * Create html for file logo container
   * 
   * @param object parentDiv
   * @param int index
   * @param object file
   * @return void
   */      
   this.createFileElement = function(parentDiv) {
     var fileLogo = parentDiv.appendChild(document.createElement("div"));
     
     var clz = document.createAttribute("class");
     clz.value = this.classes.fileLogoDiv;
     fileLogo.setAttributeNode(clz);
   };    
  /**
  * Create html for progresser
  * 
  * @param object parentDiv
  * @param int index  
  * @return void
  */      
  this.createProgresser = function(parentDiv,index) {
    /**
     * Progress bar tag
     */ 
    var fDiv = parentDiv.appendChild(document.createElement("div"));
    var clz = document.createAttribute("class");
    clz.value = this.classes.progressContainer;
    fDiv.setAttributeNode(clz);

    var sDiv = fDiv.appendChild(document.createElement("div"));

    var id = document.createAttribute("id");
    id.value = this.identifiers.progressDiv + index;
    sDiv.setAttributeNode(id);

    clz = document.createAttribute("class");
    clz.value = this.classes.progressDiv + " " + this.identifiers.progressDiv + index;
    sDiv.setAttributeNode(clz);

    var r = document.createAttribute("role");
    r.value = "progressbar";
    sDiv.setAttributeNode(r);

    var anow = document.createAttribute("aria-valuenow");
    anow.value = "0";
    sDiv.setAttributeNode(anow);

    var amin = document.createAttribute("aria-valuemin");
    amin.value = "0";
    sDiv.setAttributeNode(amin);

    var amax = document.createAttribute("aria-valuemax");
    amax.value = "100";
    sDiv.setAttributeNode(amax);

    var s = document.createAttribute("style");
    s.value = "width: 0%";
    sDiv.setAttributeNode(s);

    var fSpan = sDiv.appendChild(document.createElement("span"));
    clz = document.createAttribute("class");
    clz.value = "sr-only";
    fSpan.setAttributeNode(clz);  
  };   
  /**
  * Create html for remove icon
  * and add the listener 
  * 
  * @param object parentDiv
  * @param int index  
  * @return void
  */      
  this.createRemoveIcon = function(parentDiv,index) {
    /**
     * Icon click event is listened only when upload happen on button click
     */ 
    if(this.button){
      /**
       * Icon for removing the selected files
       */ 
      var icon = parentDiv.appendChild(document.createElement("i"));
      
      clz = document.createAttribute("class");
      clz.value = this.classes.removeIcon;
      icon.setAttributeNode(clz);

      var f = document.createAttribute("data-file");
      f.value = index;
      icon.setAttributeNode(f);

      id = document.createAttribute("id");
      id.value = this.identifiers.removeIcon + index;
      icon.setAttributeNode(id);        

      icon.addEventListener("click", this.removeFile, false);
    }    
  };
  /**
  * Create ignore hidden intput
  * this helps to ignore the uploaded image
  * 
  * @param object parentDiv
  * @param int index  
  * @return void
  */      
  this.createIgnoreHiddenElement = function(parentDiv,index) {
    if(this.file){
      /**
       * Icon for removing the selected files
       */ 
      var hidden = document.createElement("input");
      
      var type = document.createAttribute("type");
      type.value = 'hidden';
      hidden.setAttributeNode(type);

      var name = document.createAttribute("name");
      name.value = "ignore_files";
      hidden.setAttributeNode(name);

      var value = document.createAttribute("value");
      value.value = 1;
      hidden.setAttributeNode(value);        

      this.file.parentNode.appendChild(hidden);
    }    
  };    
  /**
  * Validate the image file selected
  * @param object file
  * @return object
  */      
  this.validateImageFile = function(file) {
    var validateErrors = [];

    /**
     * Valid file size selected
     * @rule fileSize 
     */ 
    if(this.options.validImage.fileSize && file.size > this.options.validImage.fileSize){
      validateErrors.push('fileSize');
    }

    /**
     * Valid file size selected
     * @rule mime 
     */ 
    if(this.options.validImage.mime && this.options.validImage.mime.indexOf(file.type.replace(/image\//g, '')) == -1){
      validateErrors.push('mime');
    }
    return validateErrors;
  };     
  /**
  * Validate the file selected
  * @param object file
  * @return object
  */      
  this.validateFile = function(file) {
    var validateErrors = [];

      /**
       * Valid file size selected
       * @rule fileSize 
       */ 
      if(this.options.validFile.fileSize && file.size > this.options.validFile.fileSize){
        validateErrors.push('otherFileSize');
      }

      return validateErrors;
  };
  /**
  * Remove the selected file from
  * @param object event
  * @return object
  */    
  this.removeFile = function(e) {
      e.stopPropagation();
      e.preventDefault();

      for(var a in UploadHandler.files){
        if(this.dataset.file == UploadHandler.files[a].index){
          UploadHandler.files.splice(a, 1);
        } 
      }

      this.parentElement.parentNode.removeChild(this.parentElement);

      if (!UploadHandler.progress.hasChildNodes() || UploadHandler.files.length == 0) {
          UploadHandler.progress.classList.add(UploadHandler.classes.hide);
          UploadHandler.button.disabled = true;
      } else if (UploadHandler.files.length < UploadHandler.ignoredFiles.length) {
          UploadHandler.button.disabled = true;
      }

      UploadHandler.cleanFileElement();
  };  
  /**
  * Validate and load the image if the selected file are validate
  * @param object file
  * @param int index
  * @return object
  */  
  this.prepareFile = function(file, index) {
      /**
       * if uploaded file is image the load it and return
       */     
      if(this.isImage(file)){
        this.loadImage(file, index);
        return;
      }
      else if(this.options.isImageFileType) {
        var validateErrors = [];
        validateErrors.push('mime');
        var parentDiv = this.createParentDiv(parentDiv,index);
        this.createElementWithError(parentDiv,index,validateErrors);
        return;
      }

      /**
       * if not image build just preview the file information with progresser
       */
      var validateErrors = UploadHandler.validateFile(file);
      UploadHandler.previewFile(file,index,null,validateErrors);
  }; 
  /**
  * is Image file check upload file is a image
  * @param object file
  * @return boolean
  */  
  this.isImage = function(file) {
      return (
          typeof file == 'object'
          && file != null
            && typeof file.hasOwnProperty('type')
          && ["image/png","image/gif","image/bmp","image/jpg","image/jpeg"].indexOf(file.type) != -1
      );
  };
  /**
  * Prepare and upload the selected files to the server
  * @return boolean 
  */    
  this.uploadPrepare = function() {
    for(var iter = 0, file; file = this.files[iter]; iter++){
      if(this.fileDone.indexOf(file.index) == -1) {
        this.fileDone.push(file.index);
        this.uploadFile(file);
        break;
      }
    }  
  };
  /**
  * Upload Progress event listener
  * @param object e
  * @param object file
  * @return void
  */    
  this.progressHandler = function(e,file) {
    var holderDiv = document.getElementById(this.options.progress),
        c = Math.round(e.loaded * 100 / e.total),
        pc = c + "%",
        progressDiv   = this.getElementUsingClass(holderDiv,this.identifiers.progressDiv + file.index),
        statParagraph = this.getElementUsingClass(holderDiv,this.identifiers.statP + file.index);

    progressDiv.dataset.ariaValuenow = pc;
    progressDiv.style.width = pc;

    var txt = document.createTextNode((c > 99) ? this.options.locale.stat.processing : this.options.locale.stat.uploading.replace(/:pc/g, pc));

    statParagraph.innerText = txt.textContent;
  };
  /**
  * Get element using class from source element
  * @param object element
  * @param object class
  * @return void
  */    
  this.getElementUsingClass = function(element,clz) {
    var elements = (typeof element == 'object') ? element.getElementsByClassName(clz) : [];

    return elements.length > 0 ? elements[0] : elements;
  };  
  /**
  * Response Handler
  * update the preview based on the server response
  * @param response file
  * @param object file
  * @return void
  */     
  this.responseHandler = function(response,file) {
      var holderDiv = document.getElementById(this.options.progress),
      parentDiv = this.getElementUsingClass(holderDiv,this.identifiers.parentDiv + file.index),
      progressDiv   = this.getElementUsingClass(holderDiv,this.identifiers.progressDiv + file.index),
      statParagraph = this.getElementUsingClass(holderDiv,this.identifiers.statP + file.index);
      
      parentDiv.classList.remove(this.classes.fileActive);

      if (response.readyState == 4 && response.status == 200) {
          progressDiv.classList.add(this.classes.success);
          txt = document.createTextNode(this.options.locale.stat.done);
          parentDiv.classList.add(this.classes.fileSuccess);
          
          if(typeof this.options.afterUpload == 'function'){
            var responseObj = this.getParseStringToJSON(response.responseText);
            if(typeof responseObj == 'object'){
              responseObj['file'] = file;
                this.options.afterUpload.call(this,responseObj);
            }
          } 
      } else if (response.readyState == 4 && response.status == 422) {
          progressDiv.classList.remove(this.classes.progressBarSuccess);
          progressDiv.classList.add(this.classes.progressBarDanger);
          txt = document.createTextNode(this.getErrorMessageFromResponse(response));
          parentDiv.classList.add(this.classes.fileError);
      } else {
          progressDiv.classList.remove(this.classes.progressBarSuccess);
          progressDiv.classList.add(this.classes.progressBarDanger);
          txt = document.createTextNode(this.options.locale.stat.failed);
          parentDiv.classList.add(this.classes.fileError);
      }
      
      statParagraph.innerText = txt.textContent;

      if(this.button){
         var removeIcon = document.getElementById(this.identifiers.removeIcon + file.index);
         
         if(typeof removeIcon == 'object' && removeIcon != null){
             removeIcon.classList.remove(this.classes.hide);
         }
      }
      
      this.uploadPrepare();    
  };
  /**
  * Get the error message from response
  * @param object response
  * @return string
  */     
  this.getErrorMessageFromResponse = function(response) {
    var message = this.getParseStringToJSON(response.responseText);
    
    if(typeof message == 'object' && message.hasOwnProperty(this.requestFileName) && message[this.requestFileName].length > 0){
      return message[this.requestFileName][0];       
    }              
    
    return (this.options.isImageFileType) ? this.options.locale.error.invalid : this.options.locale.documenterror.invalid;
  };
  /**
   * Parse string to json
   * convert the string of json to javascript JSON object
   * @param object string
   * @return object
   */     
   this.getParseStringToJSON = function(string) {
   var jsonObj = null; 
   
     if(typeof string == 'string' && typeof JSON == 'object'){
       try{
         jsonObj = JSON.parse(string);
        } catch (error) {} 
     }              

     return jsonObj;
   };   
  /**
  * Upload file to the server
  * @param object file
  * @return void
  */     
  this.uploadFile = function(file) {
    var c = 0,pc = 0,xhr = this.getXMLHttpRequest(),form = new FormData();
    form.append(this.requestFileName, file);
    document.getElementById(this.identifiers.parentDiv + file.index).classList.add(this.classes.fileActive);

    if(this.button){
      var removeIcon = document.getElementById(this.identifiers.removeIcon + file.index);        
      if(removeIcon){
        removeIcon.classList.add(this.classes.hide);
      }
    }    
    xhr.upload.addEventListener("progress", function(e) {
      UploadHandler.progressHandler(e,file);
    }, false);
    
    xhr.addEventListener("load", function() {
      UploadHandler.responseHandler(this,file);
    }, false);
    xhr.send(form);
  };             
};