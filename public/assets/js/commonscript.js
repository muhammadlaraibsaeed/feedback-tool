function toaster_off() {
    $(document).ready(function () {
        $("#toaster-close").click();
    });
}

function toaster_on(message) {
    $(document).ready(function () {
        $("#toast-text").empty().html(message);
        $("#toaster-open").click();
    });
}

function loader_on() {
    $(document).ready(function () {
        $("#loader").removeClass("d-none");
    });
}

function loader_off() {
    $(document).ready(function () {
        $("#loader").addClass("d-none");
    });
}

function array_to_object(seriArray) {
    var object = {};
    $.each(seriArray, function (index, value) {
        object[seriArray[index].name] = seriArray[index].value;
    });

    return object;
}

function reverseFormatComments(comment) {
    // Reverse Code blocks: <code>...</code> to ```
    comment = comment.replace(/<code>(.*?)<\/code>/g, "```$1```");
    // Reverse Bold: <strong>...</strong> to **...**
    comment = comment.replace(/<strong>(.*?)<\/strong>/g, "**$1**");
    // Reverse Italic: <em>...</em> to *...*
    comment = comment.replace(/<em>(.*?)<\/em>/g, "*$1*");

    return comment;
}

// Markdown text formating
function formatComments(comment) {
    // Bold: **text**
    comment = comment.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
    // Italic: *text*
    comment = comment.replace(/\*(.*?)\*/g, "<em>$1</em>");
    // Code blocks: ```code```
    comment = comment.replace(/```(.*?)```/g, "<code>$1</code>");

    return comment;
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
