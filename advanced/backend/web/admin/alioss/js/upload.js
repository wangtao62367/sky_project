/**
 * 依赖于 阿里云提供的plupload.full.min.js 文件
 * @autor wangtao 
 * @date 2017-07-31 15:20:44
 */
 var uploader = ( function(root,factory){
     return factory.call(root);
 })(this,function(root){
    let __UPLOADER = {
        options : {
            accessid : '',
            accesskey : '',
            host : '',
            policyBase64 : '',
            signature : '',
            filename : '',
            key : '',
            expire : 0,
            now : Date.parse(new Date()) / 1000,
            timestamp : Date.parse(new Date()) / 1000,
            requestUrl : ''
        },
        //发送请求  获取上传参数
        send_request(){
            var xmlhttp = null;
            if (window.XMLHttpRequest){
                xmlhttp=new XMLHttpRequest();
            }else if (window.ActiveXObject){
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
        
            if (xmlhttp!=null){
                xmlhttp.open( "GET", this.options.requestUrl, false );
                xmlhttp.send( null );
                return xmlhttp.responseText;
            }else{
                alert("Your browser does not support XMLHTTP.");
            }
        },
        //获取签名参数
        get_signature () {
            //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
            this.options.now = this.options.timestamp = Date.parse(new Date()) / 1000; 
            if (this.options.expire < this.options.now + 3){
                console.log('get new sign')
                let body = this.send_request()
                let obj = eval ("(" + body + ")");
                this.options.host = obj['data']['host']
                this.options.policyBase64 = obj['data']['policy']
                this.options.accessid = obj['data']['accessid']
                this.options.signature = obj['data']['signature']
                this.options.expire = parseInt(obj['data']['expire'])
                this.options.key = obj['data']['dir']
                console.log(this.options);
                return true;
            }
            return false;
        },
        //设置上传参数
        set_upload_param(up){
            let ret = this.get_signature()
            if (ret == true){
                let new_multipart_params = {
                    'key' : this.options.key + '${filename}',
                    'policy': this.options.policyBase64,
                    'OSSAccessKeyId': this.options.accessid, 
                    'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
                    'signature': this.options.signature,
                };

                up.setOption({
                    'url': this.options.host,
                    'multipart_params': new_multipart_params
                });

                console.log('reset uploader')
                //uploader.start();
            }
        },
        //初始化
        init (option) {
            let uploaddiv = document.getElementById(option.el);
            if(uploaddiv == undefined || uploaddiv == null || uploaddiv == ''){
                return false;
            }
            //创建container
            let container = document.createElement('div');
            container.id = 'container';
            uploaddiv.appendChild(container);
            //创建选取文件按钮
            let selectfilesbtn = document.createElement('a');
            selectfilesbtn.id = 'selectfiles';
            selectfilesbtn.href = 'javascript:void(0);';
            selectfilesbtn.className = 'btn';
            selectfilesbtn.appendChild(document.createTextNode(option.btn_text));
            //显示所选文件的容器//<div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>
            let ossfilediv = document.createElement('div');
            ossfilediv.id = 'ossfile';
            //ossfilediv.appendChild(document.createTextNode('测试'));
            uploaddiv.appendChild(ossfilediv);
            
            container.appendChild(selectfilesbtn); 
            let self = this;
            let uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                browse_button : 'selectfiles', 
                container: document.getElementById('container'),
                flash_swf_url : 'lib/plupload-2.1.2/js/Moxie.swf',
                silverlight_xap_url : 'lib/plupload-2.1.2/js/Moxie.xap',
                url : 'http://oss.aliyuncs.com',
                filters: {
                    mime_types : option.mine_types,
                    max_file_size : option.max_file_size, //最大只能上传10mb的文件
                    prevent_duplicates : true //不允许选取重复文件
                }, 

                init : {
                    //提交上传文件
                    PostInit () {
                        self.options.requestUrl = option.requestUrl ;
                        self.set_upload_param(uploader, '', false);
                        return false;
                        console.log('初始化');
                    },

                    //选取文件
                    FilesAdded (up, files) {
                    	document.getElementById('ossfile').innerHTML = '';
                        plupload.each(files, function(file) {
                            document.getElementById('ossfile').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<b></b>'
                             +'<div class="progress"><div class="progress-bar" style="width: 0%"></div></div>'
                            +'</div>'; 
                           
                        });
                    },
                    //上传文件
                    UploadFile (up, file) {
                        console.log('上传文件');
                    },
                    //上传进度
                    UploadProgress (up, file) {
                        let d = document.getElementById(file.id);
                        d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                        let prog = d.getElementsByTagName('div')[0];
                        let progBar = prog.getElementsByTagName('div')[0]
                        progBar.style.width=  file.percent+'%';
                        progBar.setAttribute('aria-valuenow', file.percent);
                    },
                    //上传完成
                    FileUploaded (up, file,info) {
                        if (info.status == 200){
                            option.fileUploaded(self.options.host + '/' +self.options.key + file.name);
                        }else{
                            option.error(info.response);
                        }
                        
                    },
                    Error: function(up, err) {
                        self.set_upload_param(up);
                        if (err.code == -600) {
                            option.error('选择的文件太大'); 
                        }
                        else if (err.code == -601) {
                            option.error('选择的文件格式错误');
                        }
                        else if (err.code == -602) {
                            option.error('选择的文件已经上传过一遍了');
                        }
                        else {
                            option.error(err.response);
                        }
                       
                    }
                }
            });

            uploader.init();
            return uploader;
        }
    };
    return __UPLOADER;
 });
