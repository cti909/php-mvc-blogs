let node_comment = (id, content, path, path_length, posting_time, creator_id, creator_name, request_user_id, comment_likes_count, is_liked)  => {
    let is_margin = '0';
    if (path_length != 0) is_margin = '50px';
    str = 
    '<div id="comment-'+id+'" style="margin-left: '+is_margin+'">'
    +'    <div id="comment-sub-'+id+'">'
    +'    <div class="card my-3">'
    +'        <div class="card-body">'
    +'            <div class="d-block">'
    +'                <strong>Posted by: '+creator_name+' | <span class="fw-normal">'+posting_time+'</span></strong>'

    if(request_user_id == creator_id) {
    str = str 
    +'                <button class="btn btn-warning" id="edit-comment-'+id+'" onclick=comment_edit('+id+')>'
    +'                    <i class="fa-solid fa-pen-to-square"></i>'
    +'                </button>'
    +'                 <button class="btn btn-danger" id="delete-comment-'+id+'" onclick=comment_delete('+id+',"'+path+'")>'
    +'                     <i class="fa-solid fa-trash"></i>'
    +'                 </button>'
    }
    str = str 			
    +'            </div>'
    +'            <p class="card-text" id="comment-text-'+id+'">'+content+'</p>'
    +'            <hr>'
    +'            <div class="d-flex">'
    +'                <button class="btn btn-outline-dark me-2" id="comment-like-'+id+'" onClick="like_comment_change('+request_user_id+','+id+','+comment_likes_count+','+is_liked+')">'

    if (is_liked == 0) {
    str = str 
    +'                    <i class="fa-regular fa-thumbs-up"></i>'
    } else {
    str = str 
    +'                    <i class="fa-solid fa-thumbs-up"></i>'
    }
    str = str 
    +'                      <span>'+comment_likes_count+'</span>'
    +'                </button>'
    +'                <button class="btn btn-outline-dark" onclick="show_reply('+id+','+request_user_id+')">'
    +'                    Reply'
    +'                </button>'
    +'            </div>'
    +'        </div>'
    +'    </div>'
    +'    <div class="hidden-comment" id="reply-'+id+'">'
    +'       <form method="POST" id="comment-add-'+id+'" enctype="multipart/form-data" comment-path="'+path+'">'
    +'            <textarea class="form-control mb-2" id="content_'+id+'" placeholder="Reply"></textarea>'
    +'            <div class="d-flex">'
    +'              <button class="form-control btn btn-outline-dark" type="submit">'
    +'                Send'
    +'              </button>'
    +'              <button class="form-control btn btn-outline-dark" type="button" onClick="hidden_reply('+id+')">'
    +'                Cancel'
    +'              </button>'
    +'            </div>'
    +'        </form>'
    +'    </div>'
    +'  </div>'
    +'</div>'
    return str;
}

let post_id = document.getElementById("post_id").value;
let payload = JSON.stringify({"post_id": post_id});

//document.getElementById('comment-add-0').addEventListener('submit', function(event) {   
$.ajax({
    url: "index.php?ctl=comments&act=get_comments_by_post",
    type: 'POST',
    data: payload,
    dataType: "json"
}).done(function(data){  
    console.log(data, '-', data.length, '-', data.length == 0);
    // let comment_root = document.getElementById("comments");
    // if (data.length > 0) {
    //     const commentItem = data[0];
    //     console.log('commentItem:::', commentItem);
    //     const htmls = `
    //     <div id="comment-${commentItem.id}" style="margin-left: 0;">
    //     <div id="comment-sub-${commentItem.id}">
    //     <div class="card my-3">
    //     <div class="card-body">
    //         <div class="d-block">
    //             <strong>Posted by: ${commentItem.creator_name} | <span class="fw-normal">${commentItem.posting_time}</span></strong> 
    //                 <button class="btn btn-warning" id="edit-comment-${commentItem.id}" onclick="comment_edit(${commentItem.id})">
    //                 <i class="fa-solid fa-pen-to-square"></i></button>
    //             <button class="btn btn-danger" id="delete-comment-${commentItem.id}" onclick='comment_delete(${commentItem.id}, ${commentItem.path})'>
    //                 <i class="fa-solid fa-trash"></i></button>
    //         </div>
    //         <p class="card-text" id="comment-text-${commentItem.id}">${commentItem.content}</p>
    //         <hr />
    //         <div class="d-flex">
    //             <button class="btn btn-outline-dark me-2" id="comment-like-${commentItem.id}" onclick="like_comment_change(${commentItem.request_user_id},${commentItem.id},${commentItem.comment_likes_count},${commentItem.is_liked})">
    //                 <i class="fa-regular fa-thumbs-up"></i> <span>0</span></button>
    //             <button class="btn btn-outline-dark" onclick="show_reply(${commentItem.id},${commentItem.request_user_id})">Reply</button>
    //         </div>
    //     </div>
    //     </div>
    //     </div>
    //     </div>`
    //     document.getElementById("comments").innerHTML += htmls
    // }

    document.getElementById('comment-add-0').addEventListener('submit', function(event) {   
        event.preventDefault();
        if (document.getElementById('content_0').value === "") {
            alert('Nhap du lieu di!!!')
            return;
        };
        let content = document.getElementById('content_0').value;
        comment_path = this.getAttribute("comment-path");
        comment_add(post_id, 0, comment_path, content);
        document.getElementById('content_0').value = "";
        // location.reload();
    });
    if (data.length == 0) {
        document.getElementById("comments").innerHTML = "<p>No comments</p>"
    } else {
        array_id = [];
        array_path = []
        for (let i=0; i<data.length; i++) {
            array_id.push(data[i].id);
            array_path.push(data[i].path);
        }
        
        for (let i=0; i<data.length; i++) {
            let comment = data[i]
            let newComment = node_comment(
                comment["id"],
                comment["content"],
                comment["path"],
                comment["path_length"],
                comment["posting_time"],
                comment["creator_id"],
                comment["creator_name"],
                comment["request_user_id"],
                comment["comment_likes_count"],
                comment["is_liked"]
            );
            document.getElementById("comments").innerHTML += newComment;
            if (comment["path_length"] !== 0) {
                // document.getElementById("comments").innerHTML += newComment;
                path_parent = comment.path.slice(0,-5); // tim den phan tu
                index = array_path.findIndex(element => element == path_parent)
                id_cmt = array_id[index]
                if (document.getElementById("comment-"+id_cmt))
                document.getElementById("comment-"+id_cmt).innerHTML += newComment;
            } 
            // else {
            // }
        }
        $( document ).ready(function() {
            for (let i=0; i<data.length; i++) {
                let comment = data[i];
                let form = document.getElementById('comment-add-' + comment.id);
                if (form) {
                    form.addEventListener('submit', function(event) {   
                        event.preventDefault();
                        let content = document.getElementById('content_' + comment.id).value;
                        comment_path = this.getAttribute("comment-path"+comment.id);
                        comment_add(post_id, comment.id, comment.path, content);
                        console.log("cmt" + comment.id);
                    });
                }
            }
        });

        // tao moi
        // if(data[0]["request_user_id"] != 0) {
            $( document ).ready(function() {
                document.getElementById('comment-add-0').addEventListener('submit', function(event) {   
                    event.preventDefault();
                    let content = document.getElementById('content_0').value;
                    comment_path = this.getAttribute("comment-path");
                    comment_add(post_id, 0, comment_path, content);
                    // console.log("aaaa")z
                });
            });
        // }
    }
//});
});

let show_reply = ($comment_id, $request_user_id) => {
    if ($request_user_id) {
        let reply = document.getElementById("reply-"+$comment_id);
        reply.classList.replace("hidden-comment", "show-comment");
    } else {
        window.location.href = "?ctl=login";
    }
}
let hidden_reply = ($comment_id) => {
    let reply = document.getElementById("reply-"+$comment_id);
    reply.classList.replace("show-comment", "hidden-comment");
}
// add comment & reply
let comment_add = (post_id, comment_id, comment_path, content) => {
    let element = document.getElementById("comment-add-"+comment_id);
    // console.log(comment_path, post_id, comment_id)
    let payload = JSON.stringify({
        "post_id": post_id,
        "comment_id": comment_id,
        "path": comment_path,
        "content": content
    });
    // console.log(payload);
    $.ajax({
        url: "index.php?ctl=comments&act=add_comment",
        type: 'POST',
        data: payload,
        contentType: "application/json"
    }).done(function(comment){ 
        if (comment["content"] === "") return;
        console.log(comment);
        let newComment = node_comment(
            comment["id"],
            comment["content"],
            comment["path"],
            comment["path_length"],
            comment["posting_time"],
            comment["creator_id"],
            comment["creator_name"],
            comment["request_user_id"],
            comment["comment_likes_count"],
            comment["is_liked"]
        );
        if (comment_id != 0) hidden_reply(comment_id);
        if (comment["path_length"] == 0) {let reset_comment = document.getElementById("content_0");
            console.log(reset_comment)
            reset_comment.value = "";
            let comment_root = document.getElementById("comments");
            comment_root.innerHTML = newComment + comment_root.innerHTML;
            return;
        } 
        // else {
        // }
        let comment_sub = document.getElementById("comment-sub-"+comment_id)
        console.log('comment_sub:::', comment_sub);
        if (!comment_sub) {
            return;
        }
        comment_sub.innerHTML += newComment;

        $( document ).ready(function() {
            if (!comment["comments_id"]) return;
            for (let i=0; i<comment["comments_id"].length; i++) {
                console.log("cre-"+i)
                let comment_id_sub = comment["comments_id"][i];
                let comment_path_sub = comment["comments_path"][i];
                let form = document.getElementById('comment-add-' + comment_id_sub);
                if (form) {
                    form.addEventListener('submit', function(event) {   
                        event.preventDefault();
                        let content = document.getElementById('content_' + comment_id_sub).value;
                        comment_path = this.getAttribute("comment-path"+comment_id_sub);
                        comment_add(post_id, comment_id_sub, comment_path_sub, content);
                        console.log("cmt" + comment_id_sub);
                    });
                }
            }
        });
    }).fail(function(comment){ console.log(comment)});
}

// edit comment
let comment_edit = (comment_id) => {
    console.log(comment_id)
    let path = document.getElementById("comment-add-"+comment_id).getAttribute("comment-path");
    console.log(path)
    let text_element = document.getElementById("comment-text-"+comment_id);
    let text = text_element.textContent;
    
    let delete_comment = document.getElementById("delete-comment-"+comment_id);
    let edit_comment = document.getElementById("edit-comment-"+comment_id);

    let textarea_element = document.createElement("textarea");
    textarea_element.setAttribute("class", "form-control m-2");
    textarea_element.setAttribute("id", "comment-text-"+comment_id);
    textarea_element.setAttribute("name", "comment-content-"+comment_id);
    textarea_element.textContent = text;

    // text_element.replaceWith(textarea_element);
    let button_edit = document.createElement('button');
    button_edit.classList.add('btn', 'btn-warning');
    button_edit.id = 'edit-comment-' + comment_id;
    button_edit.addEventListener('click', function() {
        comment_edit(comment_id);
    });
    let icon_edit = document.createElement('i');
    icon_edit.classList.add('fa-solid', 'fa-pen-to-square');
    button_edit.appendChild(icon_edit);

    let button_delete = document.createElement('button');
    button_delete.classList.add('btn', 'btn-danger');
    button_delete.id = 'delete-comment-'+comment_id;
    button_delete.addEventListener('click', function() {
        comment_delete(comment_id, path);
    });
    let icon_delete = document.createElement('i');
    icon_delete.classList.add('fa-solid', 'fa-trash');
    button_delete.appendChild(icon_delete);

    // --- add ------
    let button_save = document.createElement('button');
    button_save.classList.add('btn', 'btn-success');
    button_save.id = 'edit-comment-' + comment_id;
    button_save.addEventListener('click', function() {
        let formData = new FormData();
        formData.append('content', textarea_element.value);
        formData.append('comment_id', comment_id);

        $.ajax({
            url: "index.php?ctl=comments&act=edit_comment",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response === "error") {
                    alert("You need content");
                } else {
                    let data = response;
                    let response_content = data["content"];

                    let p = document.createElement("p");
                    p.classList.add("card-text");
                    p.id = "comment-text-" + comment_id;
                    p.innerHTML = response_content;
                    textarea_element.replaceWith(p);
                    textarea_element.remove();

                    button_save.replaceWith(button_edit);
                    button_cancel.replaceWith(button_delete);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(errorThrown);
            }
        });
    });
    let icon_save = document.createElement('i');
    icon_save.classList.add('fa-solid', 'fa-floppy-disk');
    button_save.appendChild(icon_save);

    // ---- cancel edit ----
    let button_cancel = document.createElement('button');
    button_cancel.classList.add('btn', 'btn-danger');
    button_cancel.id = 'edit-comment-' + comment_id;
    button_cancel.addEventListener('click', function() {
        button_save.replaceWith(button_edit);
        button_cancel.replaceWith(button_delete);
        textarea_element.replaceWith(text_element);
    });
    let icon_cancel = document.createElement('i');
    icon_cancel.classList.add('fa-solid', 'fa-x');
    button_cancel.appendChild(icon_cancel);

    edit_comment.replaceWith(button_save);
    delete_comment.replaceWith(button_cancel);
    text_element.replaceWith(textarea_element);
}

// delete comment
let comment_delete = (comment_id, path) => {
    let element = document.getElementById("comment-"+comment_id);
    let result = confirm("Do you want delete this comment?");
    console.log(element)
    if (result) {
        payload = JSON.stringify({
            "path": path,
            "post_id": post_id // post_id in global var
        });
        $.ajax({
            url: "index.php?ctl=comments&act=delete_comment",
            type: 'POST',
            data: payload,
            contentType: "application/json"
        }).done(function(message){  
            console.log(message);
            element.parentNode.removeChild(element);
        });
    }
}

// like change
let like_comment_change = (user_id, comment_id, like_count, is_like) => {
    like_count =parseInt(like_count);
    console.log(like_count)
    if (user_id == 0) {
        document.location.href= "?ctl=login&act=index";
    } else {
        let element = document.getElementById('comment-like-'+comment_id);
        let check_like = 1;
        if(element.innerHTML.includes("solid")) { // da like -> xoa like
            console.log("-> xoa like");      
            payload = JSON.stringify({'like':'del', 'comment_id': comment_id});
            check_like = 0;
        } else {        // chua like -> them like
            console.log("-> like");
            payload = JSON.stringify({'like':'add', 'comment_id': comment_id});
            check_like = 1;
        }
        $.ajax({
            url: "index.php?ctl=comments&act=like_comment",
            type: 'POST',
            data: payload,
            // dataType : "json",
            contentType: "application/json"
        }).done(function(message){  
            console.log(message);
            if (check_like == 0) {
                if (is_like == 1) // ban dau like
                    element.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>'+(like_count-1);
                else
                    element.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>'+(like_count);
            } else {
                if (is_like == 0) // ban dau chua like
                    element.innerHTML = '<i class="fa-solid fa-thumbs-up"></i>'+(like_count+1);
                else
                    element.innerHTML = '<i class="fa-solid fa-thumbs-up"></i>'+(like_count);
            }
        });
    }
}