/*
"app.js" serves as the main Javascript File for all Client Side Functionality
*/

// Dependencies Import for Javascript
import axios from "axios";
import "./bootstrap";
import.meta.glob(["../images/**"]);

// Downward Arrow Button to Scroll Down to Feature Section On Index/Main Page before signing in
const btnFeature = document.querySelector("[data-feature-btn]");

if (btnFeature) {
    btnFeature.addEventListener("click", () => {
        const featureSection = document.querySelector("[data-feature]");
        featureSection.scrollIntoView({ behavior: "smooth" });
    });
}

// Blogs link from the main page Header to scroll to Blogs sections
const navLinkBlogs = document.querySelector("#tab-link-blogs");

if (navLinkBlogs) {
    navLinkBlogs.addEventListener("click", (e) => {
        e.preventDefault();
        const blogList = document.querySelector("#blog-list");
        if (blogList) {
            blogList.scrollIntoView({ behavior: "smooth" });
            return;
        }
        location.href = "/";
    });
}

// Utility Function to Redirect User to a different link when button is clicked
function redirectHelper(buttons, url) {
    if (buttons instanceof NodeList) {
        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                location.href = url;
            });
        });
        return;
    }
    buttons.addEventListener("click", () => {
        location.href = url;
    });
}

// Functionality for Register and Login Buttons on Main Page
const registerButtons = document.querySelectorAll("[data-register]");

if (registerButtons) {
    redirectHelper(registerButtons, "/register");
}

const loginButtons = document.querySelectorAll("[data-login]");

if (loginButtons) {
    redirectHelper(loginButtons, "/login");
}

// Drop Down Menu for User Profile on Header top right (Arrow Button)
const btnProfileDropdown = document.querySelector("#btn-profile-dropdown");
const btnProfiles = document.querySelectorAll("[data-profile]");
const btnDashboard = document.querySelectorAll("[data-dashboard]");
const btnSettings = document.querySelectorAll("[data-settings]");
const btnLogouts = document.querySelectorAll("[data-logout]");

if (btnProfileDropdown) {
    redirectHelper(btnProfiles, "/profile");
    if (btnDashboard) {
        redirectHelper(btnDashboard, "/dashboard");
    }
    redirectHelper(btnSettings, "/settings");
    logoutEventListener();
    let dropdownState = false;
    btnProfileDropdown.addEventListener("click", () => {
        dropdownState = dropdownState === true ? false : true;
        const dropdown = document.querySelector("#profile-dropdown");
        if (dropdownState) {
            dropdown.style.display = "grid";
            return;
        }
        dropdown.style.display = "none";
    });
}

// Logout redirect
function logoutEventListener() {
    btnLogouts.forEach((button) => {
        button.addEventListener("click", () => {
            axios.post("/logout").then((res) => {
                location.href = "/";
            });
        });
    });
}

// Handling blog submission
const BlogForm = document.querySelector("#blog-form");
const categoryChoicesContainer = document.querySelector(
    "#category-choice-container"
);
const paragraphCounter = document.querySelector("#paragraph-counter");
const contentFormContainer = document.querySelector("#blog-content-container");
const btnAdd = document.querySelector("#add");
const btnSubtract = document.querySelector("#subtract");
const btnSubmit = document.querySelector("#blog-submit-preview");

// Generate Selected Categories and Previous Contents if available
// Example if user revise and edit before publishing their selected categories and paragraphs
// are retain when editing.
// If user writes a new blogpost then these functions will instead generate default props to be filled in later.
function generateCategoryProp(selectedCategoriesPreset) {
    if (selectedCategoriesPreset) {
        const categoriesIds = selectedCategoriesPreset.map((cat) => {
            return cat.id;
        });
        const categoriesName = selectedCategoriesPreset.map((cat) => {
            return cat.name;
        });
        return {
            selectedCategories: categoriesIds,
            categoriesName: categoriesName,
        };
    }
    return {
        selectedCategories: [],
        categoriesName: [],
    };
}

function generateContentProp(blogContentPreset) {
    if (blogContentPreset) {
        blogContentPreset = JSON.parse(blogContentPreset);
        return {
            paragraphCount: blogContentPreset.length,
            paragraphs: blogContentPreset,
        };
    }
    return {
        paragraphCount: 1,
        paragraphs: [],
    };
}

// Update the Text when User Selects a category when writing a blogpost
function updateCategorySelection(array) {
    const categoriesSelectedText = document.querySelector(
        "#categories-name-display"
    );
    categoriesSelectedText.innerText = `Selected Categories: ${array.join(
        " | "
    )}`;
    if (array.length < 1) {
        categoriesSelectedText.innerText =
            "No Categories Selected. It will be a general blogpost by default";
    }
}

// Event Listener to Update the DOM ie individual category elements when User Selects or Unselects depending on the state
function categoryChoiceHandler(categories) {
    categoryChoicesContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("category-choice")) {
            if (categories.selectedCategories.length < 5) {
                const choice = e.target;
                choice.classList.replace(
                    "category-choice",
                    "category-selected"
                );
                categories.selectedCategories.push(
                    choice.getAttribute("data-category")
                );
                categories.categoriesName.push(choice.innerText);
                updateCategorySelection(categories.categoriesName);
                return;
            }
        }
        if (e.target.classList.contains("category-selected")) {
            const choice = e.target;
            choice.classList.replace("category-selected", "category-choice");
            choice.getAttribute("data-category");
            categories.selectedCategories =
                categories.selectedCategories.filter((cat) => {
                    return cat !== choice.getAttribute("data-category");
                });
            categories.categoriesName = categories.categoriesName.filter(
                (cat) => {
                    return cat !== choice.innerText;
                }
            );
            updateCategorySelection(categories.categoriesName);
            return;
        }
    });
}

// Functionlity to Manipulate the DOM tree to add or subtract total editable paragraph form elements
function addParagraphFormHandler(content) {
    btnAdd.addEventListener("click", () => {
        content.paragraphCount++;
        paragraphCounter.innerText = content.paragraphCount;
        const paragraphContainer = document.createElement("div");
        const paragraphLabel = document.createElement("label");
        const paragraphForm = document.createElement("span");
        paragraphContainer.setAttribute(
            "data-p-container",
            content.paragraphCount
        );
        paragraphLabel.setAttribute("data-p-label", content.paragraphCount);
        paragraphForm.setAttribute("data-p-form", content.paragraphCount);
        paragraphForm.setAttribute("contenteditable", true);
        paragraphContainer.classList.add("p-container");
        paragraphForm.classList.add("p-form");
        paragraphLabel.innerText = `Paragraph ${content.paragraphCount}`;
        paragraphForm.innerText = `Type Here...`;
        paragraphContainer.appendChild(paragraphLabel);
        paragraphContainer.appendChild(paragraphForm);
        contentFormContainer.appendChild(paragraphContainer);
    });
}

function subtractParagraph(content) {
    btnSubtract.addEventListener("click", () => {
        if (content.paragraphCount > 1) {
            const paragraphContainer = document.querySelector(
                `[data-p-container="${content.paragraphCount}"]`
            );
            paragraphContainer.remove();
            content.paragraphCount--;
            paragraphCounter.innerText = content.paragraphCount;
        }
    });
}

function generateParagraphForm(content) {
    addParagraphFormHandler(content);
    subtractParagraph(content);
}

// Utility Functions to check if string is empty or it does not exceed a certain value
function hasEmptyString(values) {
    return values.some((value) => {
        return value === "";
    });
}

function tooShort(values, length) {
    return values.some((value) => {
        return value.length < length;
    });
}

// Handling form input errors in regards to title and paragraphs being empty or too short
function handleTitleError(titleElement, length) {
    const errorElement = document.createElement("p");
    errorElement.classList.add("error-message");
    if (titleElement.value.length === 0) {
        errorElement.innerText = "Title cannot be Empty!";
    } else if (titleElement.value.length < length) {
        errorElement.innerText = `Title is Too Short! It must be at least ${length} Characters long`;
    }
    titleElement.parentElement.appendChild(errorElement);
    titleElement.addEventListener("click", () => {
        errorElement.remove();
    });
}

function handleParagraphError(paragraphElements, length) {
    paragraphElements.forEach((element) => {
        const errorElement = document.createElement("p");
        errorElement.classList.add("error-message");
        if (element.innerText.length === 0) {
            errorElement.innerText =
                "This Paragraph Cannot be Empty! If this paragraph is not in used please remove it";
        } else if (element.innerText.length < length) {
            errorElement.innerText = `This Paragraph is Too Short! It must be at least ${length} Characters long`;
        }
        element.parentElement.appendChild(errorElement);
        element.addEventListener("click", () => {
            errorElement.remove();
        });
    });
}

function validateUserInput(blogTitleInput, content) {
    const allParagraphsFormElement = document.querySelectorAll("[data-p-form]");
    const paragraphValues = Array.from(allParagraphsFormElement).map(
        (element) => {
            return element.innerText;
        }
    );
    let status = true;
    if (hasEmptyString(paragraphValues) || tooShort(paragraphValues, 50)) {
        handleParagraphError(allParagraphsFormElement, 50);
        status = false;
    }
    if (blogTitleInput.value.length < 10) {
        handleTitleError(blogTitleInput, 10);
        status = false;
    }
    content.paragraphs = paragraphValues;
    return status;
}

// When User Clicks Submit this function is fired to Extract and Validate Form Data of written blogpost
// Handling any potential exceptions client side before submiting the form data via POST request
function previewSubmissionHandler(
    blogTitleInput,
    blogFileInput,
    categories,
    content
) {
    btnSubmit.addEventListener("click", () => {
        if (!validateUserInput(blogTitleInput, content)) return;
        const formData = new FormData();
        formData.append("title", blogTitleInput.value);
        if (blogFileInput.files[0]) {
            formData.append(
                "image",
                blogFileInput.files[0],
                blogFileInput.files[0].name
            );
        }
        if (categories.selectedCategories.length === 0) {
            categories.selectedCategories.push(3);
        }
        formData.append(
            "categories",
            JSON.stringify(categories.selectedCategories)
        );
        formData.append("content", JSON.stringify(content.paragraphs));
        previewPostRequest(formData);
    });
}

// Function to submit data to the backend api via route below
// Blogpost Form Data beyond this point is handled via app/Http/Controllers/BlogpostController.php
async function previewPostRequest(formData) {
    try {
        const res = await axios.post("/blogposts/write", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        if (res.status === 200) {
            location.href = res.data.redirect;
        }
    } catch (error) {
        console.error(error);
    }
}

// Blogpost Form Functionality Enabler ie execute all functions above if Blogpost exist
if (BlogForm && window.editMode == null) {
    const blogTitleInput = document.querySelector("#blog-title-form");
    const blogFileInput = document.querySelector("#blog-file-input");
    const categories = generateCategoryProp();
    const content = generateContentProp();
    fileInputHandler(blogFileInput);
    categoryChoiceHandler(categories);
    generateParagraphForm(content);
    BlogForm.addEventListener("submit", (e) => {
        e.preventDefault();
    });
    previewSubmissionHandler(
        blogTitleInput,
        blogFileInput,
        categories,
        content
    );
}

// For Revising and Editing rendering previously selected categories, title and Paragraphs
function renderCategoriesPreset(categories) {
    categories.selectedCategories.forEach((cat) => {
        const categoryBtn = document.querySelector(`[data-category='${cat}']`);
        categoryBtn.classList.replace("category-choice", "category-selected");
    });
    updateCategorySelection(categories.categoriesName);
}

function renderParagraphsPreset(content) {
    document.querySelector("[data-p-container='1']").remove();
    paragraphCounter.innerText = content.paragraphCount;
    content.paragraphs.forEach((paragraph, index) => {
        const paragraphContainer = document.createElement("div");
        const paragraphLabel = document.createElement("label");
        const paragraphForm = document.createElement("span");
        paragraphContainer.setAttribute("data-p-container", index + 1);
        paragraphLabel.setAttribute("data-p-label", index + 1);
        paragraphForm.setAttribute("data-p-form", index + 1);
        paragraphForm.setAttribute("contenteditable", true);
        paragraphContainer.classList.add("p-container");
        paragraphForm.classList.add("p-form");
        paragraphLabel.innerText = `Paragraph ${index + 1}`;
        paragraphForm.innerText = paragraph;
        paragraphContainer.appendChild(paragraphLabel);
        paragraphContainer.appendChild(paragraphForm);
        contentFormContainer.appendChild(paragraphContainer);
    });
}

// Blogpost Form Functionality Enabler for Editing mode ie execute all functions above if Blogpost exist
if (BlogForm && window.editMode === true) {
    const blogData = window.blogData["\0*\0attributes"]; //object
    const selectedCategories = window.selectedCategories["\0*\0items"]; //array
    const blogTitleInput = document.querySelector("#blog-title-form");
    blogTitleInput.value = blogData.title;
    const blogFileInput = document.querySelector("#blog-file-input");
    const categories = generateCategoryProp(selectedCategories);
    const content = generateContentProp(blogData.content);
    renderCategoriesPreset(categories);
    renderParagraphsPreset(content);
    fileInputHandler(blogFileInput);
    categoryChoiceHandler(categories);
    generateParagraphForm(content);
    BlogForm.addEventListener("submit", (e) => {
        e.preventDefault();
    });
    previewSubmissionHandler(
        blogTitleInput,
        blogFileInput,
        categories,
        content
    );
}

// Preview Image input when inserted into Blogpost form
function fileInputHandler(fileInput) {
    const fileChooser = document.querySelector("#choose-file");
    const fileNameDisplay = document.querySelector("#result-file");
    const fileInputContainer = document.querySelector("#file-input-container");
    const fileImageDisplay = document.createElement("img");
    fileChooser.addEventListener("click", () => {
        fileInput.click();
    });
    fileInput.addEventListener("change", () => {
        const fileSelected = fileInput.files[0];
        if (fileSelected) {
            fileNameDisplay.innerText = fileSelected.name;
            fileImageDisplay.src = URL.createObjectURL(fileSelected);
            fileImageDisplay.classList.add("w-1/2", "aspect-auto");
            fileInputContainer.prepend(fileImageDisplay);
        }
    });
}

// Blog Preview Date Display Function

const previewDateDisplay = document.querySelector("#preview-date-display");
const dateDisplay = document.querySelector("#date-display");

if (previewDateDisplay) {
    const date = new Date();
    const formattedDate = formatDateToMMMDDYYYY(date);
    const btnDiscard = document.querySelector("#preview-discard");
    const btnEdit = document.querySelector("#preview-edit");
    const btnSubmit = document.querySelector("#preview-submit");
    redirectHelper(btnDiscard, "/blogposts/preview/discard");
    redirectHelper(btnEdit, "/blogposts/preview/revise");
    redirectHelper(btnSubmit, "/blogposts/submit/final");
    previewDateDisplay.innerText = formattedDate;
}

if (dateDisplay) {
    const date = new Date(dateDisplay.innerText);
    const formattedDate = formatDateToMMMDDYYYY(date);
    dateDisplay.innerText = formattedDate;
}

function formatDateToMMMDDYYYY(date) {
    const options = { year: "numeric", month: "short", day: "numeric" };
    return new Intl.DateTimeFormat("en-US", options).format(date);
}

// Handling categories filtering

const categoriesUnselected = document.querySelectorAll(
    "[data-filter-categories]"
);

if (categoriesUnselected) {
    categoriesUnselected.forEach((btn) => {
        // For filtering multiple categories WIP!
        // btn.addEventListener("click", (e) => {
        //     const id = e.target.id;
        //     const selectedCategories = [
        //         ...new URLSearchParams(window.location.search).getAll(
        //             "category"
        //         ),
        //     ];
        //     selectedCategories.push(id);
        //     location.href = `/?category=${selectedCategories.join(",")}`;
        // });
        btn.addEventListener("click", (e) => {
            const id = e.target.id;
            location.href = `/?category=${id}`;
        });
    });
}

const categoriesSelected = document.querySelectorAll(
    "[data-seleted-categories]"
);

if (categoriesSelected) {
    categoriesSelected.forEach((category) => {
        category.addEventListener("click", () => {
            location.href = "/";
        });
    });
}

// Flash Message Functionality
function delayedDetect(selector, ms) {
    return new Promise((resolve) => {
        setTimeout(() => {
            const element = document.querySelector(selector);
            resolve(element);
        }, ms);
    });
}

async function flashMessageEvent() {
    const flashMessage = await delayedDetect("#flash-message", 1000);
    if (flashMessage) {
        window.addEventListener(
            "click",
            () => {
                flashMessage.classList.add("-translate-y-full");
                setTimeout(() => {
                    flashMessage.classList.add("hidden");
                }, 300);
            },
            { once: true }
        );
    }
}

flashMessageEvent();
