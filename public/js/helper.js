function addLikeEvent(likeBtn, api_token = "") {
    likeBtn.addEventListener("click", function() {
        var postId = this.dataset.postid;
        var userId = this.dataset.userid;
        if (userId == 0) {
            location.href = "/login";
            return;
        }
        fetch(`/api/v1/like-post?postid=${postId}&userid=${userId}`, {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + api_token
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === "liked") {
                    toastr.success("Post Liked");
                } else if (data.status === "unliked") {
                    toastr.warning("Post Unliked");
                }
                this.children[1].innerHTML = data.count;
            });
    });
}

function buildCommentNode(comment, username, time, attrs = {}) {
    var cmtNode = document.createElement("div");
    var cmtText = document.createElement("p");
    var cmtMeta = document.createElement("span");
    var cmtUser = document.createElement("strong");
    var cmtTime = document.createElement("i");
    var cmtDelete = document.createElement("button");

    // Add Classes where necessary for css styling
    cmtNode.classList.add("comment-card");
    cmtDelete.classList.add("comment-delete");

    cmtText.appendChild(document.createTextNode(comment));
    var byText = document.createTextNode("By ");
    cmtUser.appendChild(document.createTextNode(username));
    cmtTime.appendChild(document.createTextNode(" " + time));
    cmtDelete.appendChild(document.createTextNode("Delete"));

    // Add necessary attributes for delete event
    cmtDelete.setAttribute("data-userid", attrs["userid"]);
    cmtDelete.setAttribute("data-commentid", attrs["commentid"]);

    // Build Hierarchy
    cmtNode.appendChild(cmtText);
    cmtMeta.appendChild(byText);
    cmtMeta.appendChild(cmtUser);
    cmtMeta.appendChild(cmtTime);
    cmtNode.appendChild(cmtMeta);
    cmtNode.appendChild(cmtDelete);
    return cmtNode;
}

function addCommentSubmitEvent(commentForm, api_token = "") {
    commentForm.addEventListener("submit", function(e) {
        e.preventDefault();
        var postId = this.dataset.postid;
        var userId = this.dataset.userid;
        if (userId == 0) {
            location.href = "/login";
        }
        var comment = document.getElementById("comment-input").value;

        var formData = new FormData();
        formData.append("postid", postId);
        formData.append("userid", userId);
        formData.append("comment", comment);
        fetch(`/api/v1/comment-post`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + api_token,
                "X-Requested-With": "XMLHttpRequest"
            },
            credentials: "same-origin",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.status == true) {
                    var cmtNode = buildCommentNode(
                        data.comment.comment,
                        data.comment.username,
                        data.comment.diffForHumans,
                        {
                            userid: userId,
                            commentid: data.comment.id
                        }
                    );
                    // Last Child is the delete node
                    addDeleteCommentEvent(cmtNode.lastChild, api_token);
                    document.getElementById("comment-list").prepend(cmtNode);
                    document.getElementById("comment-input").value = "";
                }
            });
    });
}

function addDeleteCommentEvent(deleteBtn, api_token = "") {
    deleteBtn.addEventListener("click", function() {
        var postId = this.dataset.postid;
        var userId = this.dataset.userid;
        var commentId = this.dataset.commentid;
        var commentedId = this.dataset.commentedid;
        if (userId == 0) {
            location.href = "/login";
        }
        var formData = new FormData();
        formData.append("postid", postId);
        formData.append("userid", userId);
        formData.append("commentid", commentId);
        formData.append("commentedid", commentedId);
        fetch(`/api/v1/comment-delete`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + api_token,
                "X-Requested-With": "XMLHttpRequest"
            },
            credentials: "same-origin",
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === true) {
                    this.parentNode.remove();
                    toastr.success("Comment Deleted");
                } else {
                    toastr.warning(data.status || "Something went wrong");
                }
            });
    });
}
