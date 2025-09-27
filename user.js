// ===========================
// DATA MANAGEMENT & NAVIGATION
// ===========================

// Static/Dummy Data - These will be replaced with PHP/MySQL queries
const dummyData = {
    orders: [
        {
            orderId: "ORD-2024-001",
            date: "Dec 20, 2024",
            items: "Premium Headphones ×2",
            status: "delivered",
            total: "$299.98",
        },
        {
            orderId: "ORD-2024-002",
            date: "Dec 15, 2024",
            items: "Smart Watch ×1, Phone Case ×3",
            status: "shipped",
            total: "$247.50",
        },
        {
            orderId: "ORD-2024-003",
            date: "Dec 10, 2024",
            items: "Wireless Mouse ×1",
            status: "processing",
            total: "$49.99",
        },
        {
            orderId: "ORD-2024-004",
            date: "Dec 5, 2024",
            items: "Laptop Stand ×1, Monitor ×1",
            status: "delivered",
            total: "$456.78",
        },
        {
            orderId: "ORD-2024-005",
            date: "Nov 28, 2024",
            items: "Keyboard ×1, Desk Lamp ×1",
            status: "delivered",
            total: "$189.99",
        },
    ],
    addresses: [
        {
            type: "Home",
            recipientName: "John Doe",
            addressLine1: "123 Main Street",
            addressLine2: "Apt 4B",
            city: "New York",
            state: "NY",
            postalCode: "10001",
            country: "United States",
            isDefault: true,
        },
        {
            type: "Office",
            recipientName: "John Doe",
            addressLine1: "456 Business Ave",
            addressLine2: "Suite 200",
            city: "Brooklyn",
            state: "NY",
            postalCode: "11201",
            country: "United States",
            isDefault: false,
        },
    ],
    spendingBreakdown: [
        {
            month: "December 2024",
            amount: "$799.45",
            orders: 3,
            avgOrderValue: "$266.48",
        },
        {
            month: "November 2024",
            amount: "$1,214.56",
            orders: 4,
            avgOrderValue: "$303.64",
        },
        {
            month: "October 2024",
            amount: "$893.23",
            orders: 2,
            avgOrderValue: "$446.62",
        },
        {
            month: "September 2024",
            amount: "$340.26",
            orders: 1,
            avgOrderValue: "$340.26",
        },
    ],
};

// Navigation state
let currentSection = "overview";

// ===========================
// NAVIGATION FUNCTIONS
// ===========================

function navigateToSection(sectionName) {
    // Hide all sections
    document.querySelectorAll(".content-section").forEach((section) => {
        section.classList.remove("active");
    });

    // Remove active state from all nav links
    document.querySelectorAll(".nav-link").forEach((link) => {
        link.classList.remove("active");
    });

    // Show selected section
    const targetSection = document.getElementById(sectionName);
    const targetNavLink = document.querySelector(
        `[data-section="${sectionName}"]`
    );

    if (targetSection && targetNavLink) {
        targetSection.classList.add("active");
        targetNavLink.classList.add("active");
        currentSection = sectionName;

        // Populate section data if needed
        populateSectionData(sectionName);
    }
}

function populateSectionData(sectionName) {
    if (sectionName === "orders") {
        populateOrdersTable();
    } else if (sectionName === "addresses") {
        populateAddressesGrid();
    } else if (sectionName === "spent") {
        populateSpendingBreakdown();
    }
}

function populateOrdersTable() {
    const tableBody = document.getElementById("ordersTable");
    if (!tableBody) return;

    tableBody.innerHTML = "";

    dummyData.orders.forEach((order) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${order.orderId}</td>
                    <td>${order.date}</td>
                    <td>${order.items}</td>
                    <td><span class="status-badge ${
                        order.status
                    }">${order.status.toUpperCase()}</span></td>
                    <td>${order.total}</td>
                `;
        tableBody.appendChild(row);
    });

    // PHP: This will be replaced with a fetch request to orders.php
    // Example: fetchOrders().then(orders => { populateOrdersTable(orders); });
}

function populateAddressesGrid() {
    const addressGrid = document.getElementById("addressGrid");
    if (!addressGrid) return;

    addressGrid.innerHTML = "";

    dummyData.addresses.forEach((address, index) => {
        const addressCard = document.createElement("div");
        addressCard.className = "address-card";
        addressCard.innerHTML = `
                    <div class="address-type">${address.type}</div>
                    <div class="address-details">
                        <strong>${address.recipientName}</strong><br>
                        ${address.addressLine1}<br>
                        ${
                            address.addressLine2
                                ? address.addressLine2 + "<br>"
                                : ""
                        }
                        ${address.city}, ${address.state} ${
            address.postalCode
        }<br>
                        ${address.country}
                    </div>
                    <div class="address-actions">
                        <button class="btn btn-secondary" onclick="editAddress(${index})">Edit</button>
                        <!-- PHP: Edit button will POST to edit_address.php with address_id -->
                        <button class="btn btn-danger" onclick="deleteAddress(${index})">Delete</button>
                        <!-- PHP: Delete button will POST to delete_address.php with address_id -->
                    </div>
                `;
        addressGrid.appendChild(addressCard);
    });

    // PHP: This will be replaced with a fetch request to get_addresses.php
}

function populateSpendingBreakdown() {
    const tableBody = document.getElementById("spendingBreakdownTable");
    if (!tableBody) return;

    tableBody.innerHTML = "";

    dummyData.spendingBreakdown.forEach((item) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${item.month}</td>
                    <td>${item.amount}</td>
                    <td>${item.orders}</td>
                    <td>${item.avgOrderValue}</td>
                `;
        tableBody.appendChild(row);
    });
}

// ===========================
// FORM HANDLING
// ===========================

function handlePersonalDetailsSubmit(e) {
    e.preventDefault();

    // PHP: Replace this with actual form submission to update_profile.php
    // e.g., fetch('/api/update_profile.php', { method: 'POST', body: formData });

    showToast("Personal details saved successfully!", "success");
}

function resetForm() {
    // PHP: Reset form with original session data
    document.getElementById("personalDetailsForm").reset();
    showToast("Form reset to original values", "info");
}

// ===========================
// ADDRESS MANAGEMENT
// ===========================

function editAddress(addressIndex) {
    // PHP: Redirect to edit_address.php?address_id=${addressIndex} or show modal
    showToast(`Edit address ${addressIndex + 1}`, "info");
}

function deleteAddress(addressIndex) {
    // PHP: Confirmation dialog then POST to delete_address.php
    if (confirm("Are you sure you want to delete this address?")) {
        showToast(`Address ${addressIndex + 1} deleted`, "success");
        populateAddressesGrid(); // Refresh the grid
    }
}

function showAddAddressModal() {
    // PHP: Show modal with form or redirect to add_address.php
    showToast("Add address modal would open here", "info");
}

// ===========================
// ACTIONS & UTILITIES
// ===========================

function handleLogout() {
    // PHP: Redirect to logout.php or destroy session
    // window.location.href = '/logout.php';
    window.location.href = "index.php";
}

function showToast(message, type = "info") {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

function toggleMobileMenu() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
}

// ===========================
// INITIALIZATION
// ===========================

document.addEventListener("DOMContentLoaded", function () {
    // Set up navigation click handlers
    document.querySelectorAll(".nav-link").forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const targetSection = this.getAttribute("data-section");
            navigateToSection(targetSection);

            // Close mobile menu after navigation
            const sidebar = document.getElementById("sidebar");
            if (sidebar.classList.contains("active")) {
                sidebar.classList.remove("active");
            }
        });
    });

    // Set up form submission
    const personalForm = document.getElementById("personalDetailsForm");
    if (personalForm) {
        personalForm.addEventListener("submit", handlePersonalDetailsSubmit);
    }

    // Initial data population
    populateOrdersTable();
    populateAddressesGrid();
    populateSpendingBreakdown();

    // Populate personal details with dummy data
    const personalData = {
        firstName: "John",
        lastName: "Doe",
        email: "john.doe@example.com",
        phone: "(555) 123-4567",
        birthdate: "1990-03-15",
        city: "New York",
        country: "US",
    };

    Object.keys(personalData).forEach((key) => {
        const element = document.getElementById(key);
        if (element) {
            element.value = personalData[key];
        }
    });
});
