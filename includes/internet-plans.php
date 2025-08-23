
<section id="internet-plans">
    <h2 class="section-title">FFTH Internet Plans</h2>
    <p style="text-align: center; margin-bottom: 2rem; color: var(--gray);">Pick the best plan for you.</p>
    
    <div class="pricing-container">
        <?php if (!empty($plans)): ?>
            <?php 
            $plan_count = count($plans);
            $display_count = min($plan_count, 3); // Show max 3 initially
            
            for ($i = 0; $i < $plan_count; $i++): 
                $plan = $plans[$i];
                $is_popular = (!empty($plan['badge']) && strtolower($plan['badge']) === 'popular');
                $is_hidden = $i >= 3 ? 'hidden-plan' : '';
            ?>
                <div class="pricing-card <?php echo $is_popular ? 'popular' : ''; ?> <?php echo $is_hidden; ?>" 
                     data-index="<?php echo $i; ?>">
                    <?php if (!empty($plan['badge']) && !$is_popular): ?>
                        <span class="plan-badge"><?php echo htmlspecialchars($plan['badge']); ?></span>
                    <?php endif; ?>
                    
                    <h3><?php echo htmlspecialchars($plan['plan_name']); ?></h3>
                    <div class="price">₱<?php echo number_format($plan['price'], 2); ?> <span>/month</span></div>
                    
                    <ul class="pricing-features">
                        <?php 
                        $inclusions = $inclusions_by_plan[$plan['id']] ?? [];
                        $display_inclusions = array_slice($inclusions, 0, 3);
                        
                        foreach ($display_inclusions as $inclusion): ?>
                            <li><?php echo htmlspecialchars($inclusion); ?></li>
                        <?php endforeach; ?>
                        
                        <?php if (count($inclusions) > 3): ?>
                            <li class="text-muted">+<?php echo count($inclusions) - 3; ?> more inclusions</li>
                        <?php endif; ?>
                    </ul>
                    
                    <button class="cta-button view-plan-btn internet-plan-btn" 
                            data-plan-id="<?php echo $plan['id']; ?>"
                            data-plan-name="<?php echo htmlspecialchars($plan['plan_name']); ?>"
                            data-plan-price="₱<?php echo number_format($plan['price'], 2); ?>">
                        View Inclusions
                    </button>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <div class="no-plans-message">
                <p>No plans available at the moment. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($plan_count > 3): ?>
        <div class="view-all-container" style="text-align: center; margin-top: 2rem;">
            <button id="view-all-plans" class="secondary-button">View All Plans</button>
        </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewAllButton = document.getElementById('view-all-plans');
    const pricingContainer = document.querySelector('.pricing-container');
    const hiddenPlans = document.querySelectorAll('.hidden-plan');
    let allPlansVisible = false;
    
    if (viewAllButton && hiddenPlans.length > 0) {
        viewAllButton.addEventListener('click', function() {
            if (!allPlansVisible) {
                // Show all plans
                hiddenPlans.forEach(plan => {
                    plan.style.display = 'block';
                    setTimeout(() => {
                        plan.style.opacity = '1';
                        plan.style.transform = 'translateY(0)';
                    }, 10);
                });
                
                viewAllButton.textContent = 'View Less';
                allPlansVisible = true;
                
                // Smooth scroll to the button position after expansion
                setTimeout(() => {
                    viewAllButton.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 300);
            } else {
                // Hide extra plans (show only first 3)
                hiddenPlans.forEach(plan => {
                    plan.style.opacity = '0';
                    plan.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        plan.style.display = 'none';
                    }, 300);
                });
                
                viewAllButton.textContent = 'View All Plans';
                allPlansVisible = false;
                
                // Scroll to top of section when collapsing
                document.getElementById('internet-plans').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        });
    }
});
</script>

<style>
.hidden-plan {
    display: none;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease;
}

#internet-plans .pricing-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

#view-all-plans {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

#view-all-plans:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(28, 180, 220, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #internet-plans .pricing-container {
        grid-template-columns: 1fr;
    }
    
    .hidden-plan {
        display: none !important;
    }
}
</style>