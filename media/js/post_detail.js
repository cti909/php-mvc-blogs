










// // let elements = document.getElementsByClassName('form_cmt');
// // for (let i = 0; i < elements.length; i++) {
// //   console.log(elements[i]);
// // }

// let create_comment = (request_user_id, comment_id, comment_content, comment_count_like, comment_path, comment_check_like,
//                         user_id, user_name, comment_edit, comment_delete, like_change, comment_add) => {
//     let edit_cmt = "'"+comment_id+"','"+comment_edit+"'";
//     let str = 
//         '<div class="mt-2" id="item'+comment_id+'">'
//         +'    <div class="d-flex">'
//         +'        <div class="px-2 d-block" style="font-size: 30px;">'
//         +'            <i class="fa-solid fa-user"></i>'
//         +'        </div>'
//         +'        <div class="d-block col" id="content_card'+comment_id+'">'
//         +'            <div class="card">'
//         +'                <div class="card-header d-flex text-center align-items-center">'
//         +'                    <strong class="me-2">'+user_name+'</strong>'

//         if (request_user_id == user_id) {
//         str +=
//         '                    <div class="d-flex">'
//         +"                        <button class='btn btn-secondary mx-1' onClick="+"edit_cmt("+edit_cmt+")"+">"
//         +'                            <i class="fa-solid fa-pen-to-square"></i>'
//         +'                        </button>'
//         +'                        <button class="btn btn-secondary mx-1"onClick="delete_cmt('
//         +'                                                                        '+comment_id+','
//         +"                                                                        '"+comment_delete+"'"
//         +'                                                                        )">'
//         +'                            <i class="fa-solid fa-trash"></i>'
//         +'                        </button>'
//         +'                    </div>'
//         }

//         str +=
//         '                </div>'
//         +'                <div class="card-body">'
//         +'                    <div id="show_content'+comment_id+'">'
//         +'                        <p id="content_cmt'+comment_id+'">'+comment_content+'</p>'
//         +'                    </div>'
//         +'                    <div class="d-flex">'
//         +'                        <button class="btn btn-secondary me-2" id="like'+comment_id+'" onClick="like_cmt('
//         +'                                                                                                '+request_user_id+','
//         +'                                                                                                '+comment_id+','
//         +'                                                                                                '+comment_count_like+','
//         +"                                                                                                '"+like_change+"',"
//         if (comment_check_like) str += "'is_like'"
//         else str += "'no_like'"

//         str +=  ')">'
        
//         if (comment_check_like)
//             str +='<i class="fa-solid fa-thumbs-up"></i>'+comment_count_like
//         else 
//             str += '<i class="fa-regular fa-thumbs-up"></i>'+comment_count_like
//         str +=                         
                                    
//         '                        </button>'
//         +'                        <button class="btn btn-secondary" id="reply'+comment_id+'" onclick="show_reply('+request_user_id+","+ comment_id+')">'
//         +'                            Reply'
//         +'                        </button>'
//         +'                    </div>'
//         +'                </div>'
//         +'            </div>'
//         +'            <div class="reply">'
//         +'                <form class="mt-2 hidden-comment" id="form_cmt'+comment_id+'">'
//         +'                    <input type="text" class="form-control" id="add_cmt'+comment_id+'" name="content" placeholder="New reply">'
//         +'                    <button type="button" class="btn btn-secondary" onClick="add_form('
//         +'                                                                                '+comment_id+','
//         +"                                                                                '"+comment_path+"',"
//         +"                                                                                '"+comment_add+"'"
//         +'                                                                                )">'
//         +'                        <i class="fa-solid fa-paper-plane"></i>'
//         +'                    </button>'
//         +'                </form>'
//         +'            </div>'
//         +'        </div>'
//         +'       </div>'
//         +'</div>'
//     return str;
// }

// let product_id = document.getElementById("")
// $.ajax({
//     url: 'index.php?ctl=comments&act=get_all_comment&id=1',
//     type: 'POST',
//     data: {},
//     success: function(response) {
//         comments = response;
//         console.log(show_comment)
//         let show_comment = document.getElementById("comment").innerHTML;

//         if (comments.length == 0) {
//             document.getElementById("comment").innerHTML = "<p>No comments</p>"
//         }
//         array_id = [];
//         array_path = []
//         for (let i = 0; i < comments.length; i++) {
//             array_id.push(comments[i].id);
//             array_path.push(comments[i].path);
//         }
//         for (let i = 0; i < comments.length; i++) {             
//             let cmt = comments[i];
//             let comment_edit = "comment/comment_edit/"+{{product.id}}+"/"+cmt.id;
//             let comment_delete = "comment/comment_delete/"+cmt.id;
//             let like_change = "comment/like_change/"+cmt.id;
//             let comment_add = "comment/comment_add/"+{{product.id}}+"/"+cmt.path;
//             let request_user_id = 0
//             {% if request.user.is_authenticated %}
//                 request_user_id = {{request.user.id}};
//             {% endif %}
//             let node_comment = create_comment(
//                                     request_user_id,
//                                     cmt.id,
//                                     cmt.content,
//                                     cmt.count_like,
//                                     cmt.path,
//                                     cmt.check_like,
//                                     cmt.user_id,
//                                     cmt.user_name,
//                                     comment_edit,
//                                     comment_delete,
//                                     like_change,
//                                     comment_add
//                                     );
            
//             if (cmt.path_length == 0) {
//                 document.getElementById("comment").innerHTML += node_comment;
//             } else {
//                 path_parent = cmt.path.slice(0,-5);
//                 index = array_path.findIndex(element => element == path_parent)
//                 id_cmt = array_id[index]
//                 document.getElementById("content_card"+id_cmt).innerHTML += node_comment;
//             }
//         }
//     }
//     error: function(error) {
//       console.error(error);
//     }
// });



