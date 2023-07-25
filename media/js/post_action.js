// like change
let like_post_change = (user_id, post_id, like_count, is_like) => {
    if (user_id == 0) {
        document.location.href= "?ctl=login&act=index";
    } else {
        let element = document.getElementById("post-like-"+post_id);
        let check_like = 1;
        if(element.innerHTML.includes("solid")) { // da like -> xoa like
            console.log("-> xoa like");      
            payload = JSON.stringify({'like':'del', 'post_id': post_id});
            check_like = 0;
        } else {        // chua like -> them like
            console.log("-> like");
            payload = JSON.stringify({'like':'add', 'post_id': post_id});
            check_like = 1;
        }
        $.ajax({
            url: "index.php?ctl=posts&act=like_post",
            type: 'POST',
            data: payload,
            // dataType : "json",
            contentType: "application/json"
        }).done(function(message){  
            console.log(message);
            let text_like = document.getElementById('like-text-'+post_id);
            console.log(text_like);
            if (check_like == 0) {
                element.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>';
                if (is_like == 1) // ban dau like
                    text_like.innerHTML = (like_count-1) + " people liked";
                else
                    text_like.innerHTML = (like_count) + " people liked";
            } else {
                element.innerHTML = '<i class="fa-solid fa-thumbs-up"></i>';
                if (is_like == 0) // ban dau chua like
                    text_like.innerHTML = "You and " + (like_count) + " people liked";
                else
                    text_like.innerHTML = "You and " + (like_count-1) + " people liked";
                
            }
        });
    }
}

// delete post
let post_delete = (post_id, is_detail) => {
    let element = document.getElementById("post-"+post_id);
    let result = confirm("Do you want delete this post?");
    console.log(element)
    if (result) {
        payload = JSON.stringify({"post_id": post_id});
        $.ajax({
            url: "index.php?ctl=posts&act=delete_post",
            type: 'POST',
            data: payload,
            contentType: "application/json"
        }).done(function(message){  
            console.log(message);
            // is_detail=0 -> post, is_detail=1 -> detail
            if(is_detail == 0) {
                element.parentNode.removeChild(element);
            } else {
                window.location.href="index.php?ctl=posts&act=index"
            }
        });
    }
}

// edit post
let post_edit_form = (post_id) => {
    console.log(post_id)
    let text_element = document.getElementById("content-text-"+post_id);
    let text = text_element.textContent;
    let image_element = document.getElementById("input-file-"+post_id);
    let delete_post = document.getElementById("delete-post-"+post_id);
    let edit_post = document.getElementById("edit-post-"+post_id);

    let textarea_element = document.createElement("textarea");
    textarea_element.setAttribute("class", "form-control mb-2");
    textarea_element.setAttribute("id", "content-text-"+post_id);
    textarea_element.setAttribute("name", "content-"+post_id);
    textarea_element.textContent = text;

    let input_img_element = document.createElement("input");
    input_img_element.setAttribute("class", "form-control my-2");
    input_img_element.setAttribute("type", "file");
    input_img_element.setAttribute("name", "image-"+post_id);

    let button_edit = document.createElement('button');
    button_edit.classList.add('btn', 'btn-warning');
    button_edit.id = 'edit-post-' + post_id;
    button_edit.addEventListener('click', function() {
        post_edit_form(post_id);
    });
    let icon_edit = document.createElement('i');
    icon_edit.classList.add('fa-solid', 'fa-pen-to-square');
    button_edit.appendChild(icon_edit);

    let button_delete = document.createElement('button');
    button_delete.classList.add('btn', 'btn-danger');
    button_delete.id = 'delete-post-'+post_id;
    button_delete.addEventListener('click', function() {
        post_delete(post_id, 0);
    });
    let icon_delete = document.createElement('i');
    icon_delete.classList.add('fa-solid', 'fa-trash');
    button_delete.appendChild(icon_delete);

    // --- add ------
    let button_save = document.createElement('button');
    button_save.classList.add('btn', 'btn-success');
    button_save.id = 'edit-post-' + post_id;
    button_save.addEventListener('click', function() {
        let formData = new FormData();
        let image_temp = document.getElementById("content-image-"+post_id);
        if (image_temp !== null) {
            image_temp_src = image_temp.getAttribute("src");
            image_name_array = image_temp_src.split("/");
            image_name = image_name_array[image_name_array.length-1];
            console.log(image_name);
            formData.append('image_temp', image_name);
        }
        
        formData.append('image', input_img_element.files[0]);
        formData.append('content', textarea_element.value);
        formData.append('post_id', post_id);

        $.ajax({
            url: "index.php?ctl=posts&act=edit_post",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response.trim() === "error") {
                    alert("You need content or image");
                } else {
                    let data = JSON.parse(response);
                    let response_content = data["content"];
                    let response_image = data.image;
                    console.log(response_image);

                    let p = document.createElement("p");
                    p.classList.add("card-text");
                    p.id = "content-text-" + post_id;
                    p.innerHTML = response_content;
                    textarea_element.replaceWith(p);
                    textarea_element.remove();
                    
                    if (response_image != "") {
                        let img = document.createElement("img");
                        img.classList.add("img-thumbnail");
                        img.id = "content-image-" + post_id;
                        img.src = "media/upload/posts/"+response_image;
                        img.alt = "loading";
                        image_temp.replaceWith(img);
                    }
                    button_save.replaceWith(button_edit);
                    button_cancel.replaceWith(button_delete);
                    input_img_element.remove();
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
    button_cancel.id = 'edit-post-' + post_id;
    button_cancel.addEventListener('click', function() {
        button_save.replaceWith(button_edit);
        button_cancel.replaceWith(button_delete);
        textarea_element.replaceWith(text_element);
        input_img_element.remove();
    });
    let icon_cancel = document.createElement('i');
    icon_cancel.classList.add('fa-solid', 'fa-x');
    button_cancel.appendChild(icon_cancel);

    edit_post.replaceWith(button_save);
    delete_post.replaceWith(button_cancel);
    text_element.replaceWith(textarea_element);
    image_element.appendChild(input_img_element);
}