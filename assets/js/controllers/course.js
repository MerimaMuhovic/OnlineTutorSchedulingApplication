class CourseTemplate {

    static init(){
      $("#add-email-template").validate({
        submitHandler: function(form, event) {
          var data = AUtils.form2json($(form));
          if (data.id){
            CourseTemplate.update(data);
          }else{
            CourseTemplate.add(data);
          }
        }
      });
      CourseTemplate.get_all();
    }

    
  
    static get_all(){
      $("#email-templates-table").DataTable({
        processing: true,
        serverSide: true,
        bDestroy: true,
        pagingType: "simple",
        preDrawCallback: function( settings ) {
          if (settings.aoData.length < settings._iDisplayLength){
            //disable pagination
            settings._iRecordsTotal=0;
            settings._iRecordsDisplay=0;
          }else{
            //enable pagination
            settings._iRecordsTotal=100000000;
            settings._iRecordsDisplay=1000000000;
          }
        },
        responsive: true,
        language: {
              "zeroRecords": "Nothing found - sorry",
              "info": "Showing page _PAGE_",
              "infoEmpty": "No records available",
              "infoFiltered": ""
        },
        ajax: {
          url: "api/courses",
          type: "GET",
          beforeSend: function(xhr){
            xhr.setRequestHeader('Authentication', localStorage.getItem("token"));
          },
          dataSrc: function(resp){
            return resp;
          },
          data: function ( d ) {
            d.offset=d.start;
            d.limit=d.length;
            d.search = d.search.value;
            delete d.start;
            delete d.length;
            delete d.columns;
            delete d.draw;
            console.log(d);
          }
        },
        columns: [
              { "data": "id",
                "render": function ( data, type, row, meta ) {
                  return '<div style="min-width: 60px;"> <span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="CourseTemplate.pre_edit('+data+')"><i class="fa fa-edit"></i></a> </div>'+
                  '<div style="min-width: 60px;"><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="CourseTemplate.delete('+data+'); "><i class="fa fa-trash"></i></a> </div>';
                }
              },
              { "data": "courseName" },
              { "data": "description" },
              { "data": "tutorID" }
          ]
      });
    }
  
    static add(email_template){
      RestClient.post("api/courses/", email_template, function(data){
        toastr.success("Course has been created");
        CourseTemplate.get_all();
        $("#add-email-template").trigger("reset");
        $('#add-email-template-modal').modal("hide");
      });
    }
  
    static update(email_template){
      RestClient.put("api/courses/"+email_template.id, email_template, function(data){
        toastr.success("Course has been updated");
        CourseTemplate.get_all();
        $("#add-email-template").trigger("reset");
        $("#add-email-template *[courseName='id']").val("");
        $('#add-email-template-modal').modal("hide");
      });
    }
  
    static pre_edit(id){
        RestClient.get("api/courses/"+id, function(data){
          AUtils.json2form("#add-email-template", data);
          $("#add-email-template-modal").modal("show");
        });
      }

      static delete(id){
        $('.note-button').attr('disabled', true);
        $.ajax({
          url: 'api/courses/'+id,
          beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
          },
          type: 'DELETE',
          success: function(result) {
              $("#note-list").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
              CourseTemplate.get_all();
              toastr.success("Course Deleted!");
          }
        });
      }

  }