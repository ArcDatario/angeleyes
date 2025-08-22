<section id="pricing">
    <h2 class="section-title">Cable TV Subscription</h2>
    <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Enjoy entertainment for the whole family with our cable packages.</p>
    
    <div class="pricing-container">
        <!-- Basic Plan -->
        <div class="pricing-card">
            <br>
            <h3>Basic Entertainment</h3>
            <div class="price">₱499.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>60+ Local Channels</li>
                <li>10+ News Channels</li>
                <li>5 Popular Movie Channels</li>
                <li class="text-muted">+5 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Basic Entertainment"
                    data-plan-price="₱499.00">
                View All Channels
            </button>
        </div>
        
        <!-- Family Plan (Popular) -->
        <div class="pricing-card popular">
            <span class="plan-badge">Most Popular</span>
            <h3>Family Package</h3>
            <div class="price">₱799.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>80+ Local & International Channels</li>
                <li>15+ Kids & Educational Channels</li>
                <li>Premium Sports Channels</li>
                <li class="text-muted">+8 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Family Package"
                    data-plan-price="₱799.00">
                View All Channels
            </button>
        </div>
        
        <!-- Premium Plan -->
        <div class="pricing-card">
            <br>
            <h3>Premium Experience</h3>
            <div class="price">₱1,299.00 <span>/month</span></div>
            
            <ul class="pricing-features">
                <li>120+ Local & International Channels</li>
                <li>All Premium Movie Channels</li>
                <li>HD Sports & PPV Events</li>
                <li class="text-muted">+12 more inclusions</li>
            </ul>
            
            <button class="cta-button view-plan-btn cable-plan-btn" 
                    data-plan-name="Premium Experience"
                    data-plan-price="₱1,299.00">
                View All Channels
            </button>
        </div>
    </div>
</section>
<!-- Replace your existing modals with this code -->
<!-- Inclusions Modal -->
<div class="modal fade" id="inclusionsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inclusionsModalLabel">Plan Inclusions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modalPlanName" class="mb-3"></h4>
                <div class="price mb-3" id="modalPlanPrice"></div>
                <ul id="modalInclusionsList" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="cta-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Cable TV Channels Modal -->
<div class="modal fade" id="cableChannelsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cableChannelsModalLabel">Cable TV Channels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modalCablePlanName" class="mb-3"></h4>
                <div class="price mb-3" id="modalCablePlanPrice"></div>
                <div class="channels-container">
                    <h5>Included Channels:</h5>
                    <div class="channels-list" id="channelsList">
                        <!-- Channels will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cta-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Internet Plans modal handling
    const internetPlanButtons = document.querySelectorAll('.internet-plan-btn');
    const inclusionsModal = new bootstrap.Modal(document.getElementById('inclusionsModal'));
    const modalPlanName = document.getElementById('modalPlanName');
    const modalPlanPrice = document.getElementById('modalPlanPrice');
    const modalInclusionsList = document.getElementById('modalInclusionsList');
    
    // Store inclusions data for each plan
    const plansData = <?php echo json_encode($inclusions_by_plan); ?>;
    
    internetPlanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const planId = this.getAttribute('data-plan-id');
            const planName = this.getAttribute('data-plan-name');
            const planPrice = this.getAttribute('data-plan-price');
            const inclusions = plansData[planId] || [];
            
            // Update modal content
            modalPlanName.textContent = planName;
            modalPlanPrice.innerHTML = planPrice + ' <span>/month</span>';
            modalInclusionsList.innerHTML = '';
            
            if (inclusions.length > 0) {
                inclusions.forEach(inclusion => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = inclusion;
                    modalInclusionsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.className = 'list-group-item text-muted';
                li.textContent = 'No inclusions available for this plan.';
                modalInclusionsList.appendChild(li);
            }
            
            // Show modal
            inclusionsModal.show();
            
            // Move focus to the close button when modal is shown
            $('#inclusionsModal').on('shown.bs.modal', function () {
                $(this).find('.btn-close').focus();
            });
        });
    });
    
    // Cable TV modal handling
    const cablePlanButtons = document.querySelectorAll('.cable-plan-btn');
    const cableModal = new bootstrap.Modal(document.getElementById('cableChannelsModal'));
    const modalCablePlanName = document.getElementById('modalCablePlanName');
    const modalCablePlanPrice = document.getElementById('modalCablePlanPrice');
    const channelsList = document.getElementById('channelsList');
    
    // Define channel lists for each plan
    const cablePlansData = {
        "Basic Entertainment": [
            "ABS-CBN", "GMA", "TV5", "CNN Philippines", "ANC", 
            "PTV", "IBC", "UNTV", "Net 25", "SMNI",
            "Cinema One", "My Movie Channel", "Jack TV", "Balls", "Solar Sports"
        ],
        "Family Package": [
            "All Basic Plan Channels", "Cartoon Network", "Disney Channel", "Nickelodeon", "Boomerang",
            "Discovery Channel", "National Geographic", "Animal Planet", "History", "FOX",
            "HBO", "Fox Movies", "AXN", "ESPN", "Fox Sports"
        ],
        "Premium Experience": [
            "All Family Package Channels", "HBO HD", "Cinemax", "Fox Family Movies", "TNT",
            "NBA TV", "BeIN Sports", "Setanta Sports", "Food Network", "TLC",
            "MTV", "VH1", "E!", "Lifetime", "Crime & Investigation"
        ]
    };
    
    cablePlanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const planName = this.getAttribute('data-plan-name');
            const planPrice = this.getAttribute('data-plan-price');
            const channels = cablePlansData[planName] || [];
            
            // Update modal content
            modalCablePlanName.textContent = planName;
            modalCablePlanPrice.innerHTML = planPrice + ' <span>/month</span>';
            channelsList.innerHTML = '';
            
            if (channels.length > 0) {
                channels.forEach(channel => {
                    const channelItem = document.createElement('div');
                    channelItem.className = 'channel-item';
                    channelItem.textContent = channel;
                    channelsList.appendChild(channelItem);
                });
            } else {
                const noChannels = document.createElement('div');
                noChannels.className = 'text-muted';
                noChannels.textContent = 'No channel information available.';
                channelsList.appendChild(noChannels);
            }
            
            // Show modal
            cableModal.show();
            
            // Move focus to the close button when modal is shown
            $('#cableChannelsModal').on('shown.bs.modal', function () {
                $(this).find('.btn-close').focus();
            });
        });
    });
    
    // Handle focus when modals are hidden
    $('#inclusionsModal, #cableChannelsModal').on('hidden.bs.modal', function () {
        // Return focus to the button that opened the modal
        $('.view-plan-btn:focus').focus();
    });
});
</script>

<style>
.channels-container {
    max-height: 300px;
    overflow-y: auto;
}

.channel-item {
    padding: 8px 12px;
    border-bottom: 1px solid #eee;
}

.channel-item:last-child {
    border-bottom: none;
}

#internet-plans .pricing-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
    margin-top: 2rem;
}

#internet-plans .pricing-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.34);
    text-align: center;
    flex: 1;
    min-width: 280px;
    max-width: 350px;
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#internet-plans .pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

#internet-plans .plan-badge {
    position: absolute;
    top: 10px;
    right: 20px;
    background: var(--primary);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

#internet-plans .pricing-card h3 {
    color: var(--dark);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

#internet-plans .price {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1.5rem;
}

#internet-plans .price span {
    font-size: 1rem;
    color: var(--gray);
    font-weight: 400;
}

#internet-plans .pricing-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

#internet-plans .pricing-features li {
    padding: 0.5rem 0;
    color: var(--dark);
}

#internet-plans .pricing-features .text-muted {
    color: var(--gray) !important;
}

#internet-plans .cta-button {
    display: inline-block;
    background: var(--primary);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

#internet-plans .cta-button:hover {
    background: var(--primary-light);
    transform: translateY(-2px);
}

#internet-plans .pricing-card.popular {
    border: 2px solid var(--primary);
    transform: scale(1.05);
}

#internet-plans .pricing-card.popular:hover {
    transform: scale(1.05) translateY(-5px);
}

@media (max-width: 768px) {
    #internet-plans .pricing-container {
        flex-direction: column;
        align-items: center;
    }
    
    #internet-plans .pricing-card {
        width: 100%;
        max-width: 100%;
    }
    
    #internet-plans .pricing-card.popular {
        transform: none;
    }
    
    #internet-plans .pricing-card.popular:hover {
        transform: translateY(-5px);
    }
}
</style>